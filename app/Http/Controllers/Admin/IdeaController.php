<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IdeaController extends Controller
{
    private function makeUniqueSlug($slug, $title, $ignoreId = null)
    {
        $base = Str::slug($slug ?: $title);
        $slug = $base;
        $i = 1;
        while (Idea::where("slug", $slug)->when($ignoreId, fn($q) => $q->where("id", "!=", $ignoreId))->exists()) {
            $slug = $base . "-" . $i++;
        }
        return $slug;
    }

    public function index()
    {
        $ideas = Idea::with("translations", "category")->latest()->paginate(15);
        $categories = Category::all();
        return view("admin.ideas.index", compact("ideas", "categories"));
    }

    public function create()
    {
        $categories = Category::with("translations")->get();
        $idea = null;
        $en = null;
        return view("admin.ideas.form", compact("categories", "idea", "en"));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $slug = $this->makeUniqueSlug($data["slug"] ?? "", $data["en_title"] ?? "", null);

        DB::transaction(function () use ($data, $request, $slug) {
            $idea = new Idea();
            $idea->category_id = $data["category_id"] ?? null;
            $idea->slug = $slug;
            $idea->cover_image = $request->input("cover_image_url") ?? $request->input("cover_image") ?? ($request->hasFile("cover_image") ? $request->file("cover_image")->store("ideas", "r2") : null);
            $idea->video_url = $data["video_url"] ?? null;
            $idea->capital = $data["capital"] ?? null;
            $idea->expected_profit = $data["expected_profit"] ?? null;
            $idea->currency = $data["currency"] ?? "RWF";
            $idea->difficulty_level = $data["difficulty_level"] ?? null;
            $idea->time_to_start = $data["time_to_start"] ?? null;
            $idea->operating_costs = $data["operating_costs"] ?? null;
            $idea->expected_revenue = $data["expected_revenue"] ?? null;
            $idea->is_featured = $request->boolean("is_featured");
            $idea->is_published = $request->boolean("is_published");
            $idea->published_at = $idea->is_published ? now() : null;
            $idea->save();

            $idea->translations()->create([
                "locale" => "en",
                "title" => $data["en_title"],
                "short_description" => $data["en_short_description"] ?? null,
                "full_description" => $data["en_full_description"] ?? null,
                "steps" => $data["en_steps"] ?? null,
                "requirements" => $data["en_requirements"] ?? null,
                "tips" => $data["en_tips"] ?? null,
            ]);
        });

        return redirect()->route("admin.ideas.index")->with("success", "Idea created successfully.");
    }

    public function edit(Idea $idea)
    {
        $idea->load("translations");
        $categories = Category::with("translations")->get();
        $en = $idea->translations->where("locale", "en")->first();
        return view("admin.ideas.form", compact("idea", "categories", "en"));
    }

    public function update(Request $request, Idea $idea)
    {
        $data = $request->all();
        $slug = $this->makeUniqueSlug($data["slug"] ?? "", $data["en_title"] ?? "", $idea->id);

        DB::transaction(function () use ($data, $request, $idea, $slug) {
            $idea->category_id = $data["category_id"] ?? null;
            $idea->slug = $slug;
            if (isset($data["cover_image"])) $idea->cover_image = $request->input("cover_image_url") ?? $request->input("cover_image") ?? ($request->hasFile("cover_image") ? $request->file("cover_image")->store("ideas", "r2") : null);
            $idea->video_url = $data["video_url"] ?? null;
            $idea->capital = $data["capital"] ?? null;
            $idea->expected_profit = $data["expected_profit"] ?? null;
            $idea->is_featured = $request->boolean("is_featured");
            $idea->is_published = $request->boolean("is_published");
            $idea->save();

            $trans = $idea->translations()->where("locale", "en")->first();
            if ($trans) {
                $trans->update([
                    "title" => $data["en_title"],
                    "short_description" => $data["en_short_description"] ?? null,
                    "full_description" => $data["en_full_description"] ?? null,
                ]);
            }
        });

        return redirect()->route("admin.ideas.index")->with("success", "Idea updated.");
    }

    public function destroy(Idea $idea)
    {
        $idea->forceDelete();
        return back()->with("success", "Idea deleted.");
    }

    public function togglePublish(Idea $idea) { $idea->is_published = !$idea->is_published; $idea->save(); return back()->with("success", "Status updated."); }
    public function toggleFeatured(Idea $idea) { $idea->is_featured = !$idea->is_featured; $idea->save(); return back()->with("success", "Feature updated."); }
}