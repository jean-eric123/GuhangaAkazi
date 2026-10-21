<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OpportunityController extends Controller {
    public function index() { $opportunities = Opportunity::with("translations")->latest()->paginate(15); return view("admin.opportunities.index", compact("opportunities")); }
    public function create() { return view("admin.opportunities.form"); }
    public function store(Request $request) {
        $path = $request->input("cover_image_url") ?? ($request->hasFile("cover_image") ? $request->file("cover_image")->store("opportunities", "r2") : null);
        $opp = Opportunity::create(["slug" => Str::slug($request->title)."-".Str::random(5), "cover_image" => $path, "is_published" => $request->boolean("is_published", true)]);
        $opp->translations()->create(["locale" => "en", "title" => $request->title, "short_description" => $request->description]);
        return redirect()->route("admin.opportunities.index")->with("success", "Opportunity created.");
    }
    public function edit(Opportunity $opportunity) { $opportunity->load("translations"); return view("admin.opportunities.form", compact("opportunity")); }
    public function update(Request $request, Opportunity $opportunity) {
        if ($request->hasFile("cover_image")) $opportunity->cover_image = $request->file("cover_image")->store("opportunities", "r2");
        $opportunity->save();
        $trans = $opportunity->translations()->where("locale", "en")->first();
        if ($trans) { $trans->update(["title" => $request->title, "short_description" => $request->description]); }
        return redirect()->route("admin.opportunities.index")->with("success", "Opportunity updated.");
    }
    public function destroy(Opportunity $opportunity) { $opportunity->forceDelete(); return back()->with("success", "Deleted."); }
}