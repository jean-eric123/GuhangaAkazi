<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function create() { return view("admin.photos.form"); }

    public function store(Request $request) {
        $request->validate(['title' => 'required|string|max:255', 'image' => 'required|image|max:5120']);
        $path = $request->file('image')->store('photos', 'r2');
        $photo = Photo::create(['file_path' => $path, 'is_published' => $request->boolean('is_published', true)]);
        $photo->translations()->create(['locale' => 'en', 'title' => $request->title, 'description' => $request->description]);
        return redirect()->route('admin.photos.index')->with('success', 'Photo uploaded to Cloudflare R2!');
    }

    public function index()
    {
        $photos = Photo::with("translations")->latest()->paginate(24);
        return view("admin.photos.index", compact("photos"));
    }

    public function edit(Photo $photo)
    {
        $photo->load("translations");
        return view("admin.photos.form", compact("photo"));
    }

    public function update(Request $request, Photo $photo)
    {
        $request->validate(["title" => "required"]);
        
        if ($request->hasFile("file_path")) {
            $photo->file_path = $request->file("file_path")->store("photos", "r2");
        }
        $photo->is_published = $request->boolean("is_published", true);
        $photo->save();
        
        $trans = $photo->translations()->where("locale", "en")->first();
        if ($trans) {
            $trans->update(["title" => $request->title, "description" => $request->description]);
        } else {
            $photo->translations()->create(["locale" => "en", "title" => $request->title, "description" => $request->description]);
        }

        return redirect()->route("admin.photos.index")->with("success", "Photo updated.");
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return back()->with("success", "Photo deleted.");
    }
}