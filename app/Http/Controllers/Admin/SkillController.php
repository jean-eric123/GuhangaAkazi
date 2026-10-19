<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    public function index() {
        $skills = Skill::with("translations")->latest()->paginate(15);
        return view("admin.skills.index", compact("skills"));
    }
    public function create() { return view("admin.skills.form"); }
    public function store(Request $request) {
        $request->validate(["title" => "required|string|max:255"]);
        $path = $request->hasFile("cover_image") ? $request->file("cover_image")->store("skills", "r2") : null;
        $skill = Skill::create(["slug" => Str::slug($request->title) . "-" . Str::random(5), "cover_image" => $path, "is_published" => $request->boolean("is_published", true)]);
        $skill->translations()->create(["locale" => "en", "title" => $request->title, "short_description" => $request->description]);

        if ($path) {
            $photo = \App\Models\Photo::create(["file_path" => $path, "is_published" => true]);
            $photo->translations()->create(["locale" => "en", "title" => $request->title, "description" => $request->description]);
        }
        return redirect()->route("admin.skills.index")->with("success", "Skill created.");
    }
    public function edit(Skill $skill) {
        $skill->load("translations");
        return view("admin.skills.form", compact("skill"));
    }
    public function update(Request $request, Skill $skill) {
        $request->validate(["title" => "required|string|max:255"]);
        if ($request->hasFile("cover_image")) { $skill->cover_image = $request->file("cover_image")->store("skills", "r2"); }
        $skill->is_published = $request->boolean("is_published", true);
        $skill->save();
        $trans = $skill->translations()->where("locale", "en")->first();
        if ($trans) { $trans->update(["title" => $request->title, "short_description" => $request->description]); }
        else { $skill->translations()->create(["locale" => "en", "title" => $request->title, "short_description" => $request->description]);

        if ($path) {
            $photo = \App\Models\Photo::create(["file_path" => $path, "is_published" => true]);
            $photo->translations()->create(["locale" => "en", "title" => $request->title, "description" => $request->description]);
        } }
        return redirect()->route("admin.skills.index")->with("success", "Skill updated.");
    }
    public function destroy(Skill $skill) {
        $skill->delete();
        return redirect()->route("admin.skills.index")->with("success", "Skill deleted.");
    }
}