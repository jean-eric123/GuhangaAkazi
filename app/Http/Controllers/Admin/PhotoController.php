<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::with("translations")->latest()->paginate(24);
        return view("admin.photos.index", compact("photos"));
    }

    public function create()
    {
        return view("admin.photos.form");
    }

    public function store(Request $request)
    {
        $request->validate(["title" => "required|string|max:255", "image" => "nullable|image|max:5120"]);
        
        if (!$request->filled("file_url") && !$request->hasFile("image")) {
            return back()->withErrors(["image" => "Please select a file or paste a link."]);
        }

        if ($request->filled("file_url")) {
            $path = $request->file_url;
        } else {
            $path = $request->file("image")->store("photos", "r2");
        }

        $photo = Photo::create(["file_path" => $path, "is_published" => $request->boolean("is_published", true)]);
        $photo->translations()->create(["locale" => "en", "title" => $request->title, "description" => $request->description]);
        
        return redirect()->route("admin.photos.index")->with("success", "Photo saved successfully!");
    }

    public function edit(Photo $photo)
    {
        $photo->load("translations");
        return view("admin.photos.form", compact("photo"));
    }
    
    public function update(Request $request, Photo $photo)
    {
        $request->validate(["title" => "required"]);
        if ($request->filled("file_url")) { $photo->file_path = $request->file_url; }
        elseif ($request->hasFile("image")) { $photo->file_path = $request->file("image")->store("photos", "r2"); }
        $photo->is_published = $request->boolean("is_published", true);
        $photo->save();
        $trans = $photo->translations()->where("locale", "en")->first();
        if ($trans) { $trans->update(["title" => $request->title, "description" => $request->description]); }
        return redirect()->route("admin.photos.index")->with("success", "Photo updated.");
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return back()->with("success", "Photo deleted.");
    }
}