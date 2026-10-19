<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with("translations")->latest()->paginate(15);
        return view("admin.videos.index", compact("videos"));
    }

    public function create()
    {
        return view("admin.videos.form");
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "file" => "required|file|mimes:mp4,mov,webm|max:102400",
        ]);

        $file = $request->file("file");
        $filename = Str::slug($request->title) . "-" . Str::random(6) . "." . $file->getClientOriginalExtension();
        
        // Save directly to Cloudflare R2
        $path = $file->storeAs("media/videos", $filename, "r2");

        $video = Video::create([
            "file_path" => $path,
            "is_published" => $request->boolean("is_published", true),
            "is_featured" => $request->boolean("is_featured", false),
        ]);

        $video->translations()->create([
            "locale" => "en",
            "title" => $request->title,
        ]);

        return redirect()->route("admin.videos.index")->with("success", "Video uploaded to Cloudflare R2 successfully.");
    }

    public function edit(Video $video)
    {
        $video->load("translations");
        return view("admin.videos.form", compact("video"));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "file" => "nullable|file|mimes:mp4,mov,webm|max:102400",
        ]);

        if ($request->hasFile("file")) {
            $file = $request->file("file");
            $filename = Str::slug($request->title) . "-" . Str::random(6) . "." . $file->getClientOriginalExtension();
            $video->file_path = $file->storeAs("media/videos", $filename, "r2");
        }

        $video->is_published = $request->boolean("is_published", true);
        $video->is_featured = $request->boolean("is_featured", false);
        $video->save();

        $trans = $video->translations()->where("locale", "en")->first();
        if ($trans) {
            $trans->update(["title" => $request->title]);
        } else {
            $video->translations()->create(["locale" => "en", "title" => $request->title]);
        }

        return redirect()->route("admin.videos.index")->with("success", "Video updated.");
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return back()->with("success", "Video deleted.");
    }
}