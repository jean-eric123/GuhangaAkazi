<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index() { $videos = Video::with("translations")->latest()->paginate(15); return view("admin.videos.index", compact("videos")); }
    public function create() { return view("admin.videos.form"); }
    
    public function store(Request $request) {
        $request->validate(["title" => "required|string|max:255"]);
        
        if ($request->filled('video_url')) {
            $video = Video::create(["file_path" => $request->video_url, "is_published" => $request->boolean("is_published", true), "is_featured" => $request->boolean("is_featured", false)]);
        } else {
            $request->validate(["video" => "required|file|mimes:mp4,mov,webm|max:102400"]);
            $file = $request->file("video");
            $filename = Str::slug($request->title) . "-" . Str::random(6) . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs("media/videos", $filename, "r2");
            $video = Video::create(["file_path" => $path, "is_published" => $request->boolean("is_published", true), "is_featured" => $request->boolean("is_featured", false)]);
        }
        
        $video->translations()->create(["locale" => "en", "title" => $request->title]);
        return redirect()->route("admin.videos.index")->with("success", "Video saved.");
    }
    
    public function edit(Video $video) { $video->load("translations"); return view("admin.videos.form", compact("video")); }
    
    public function update(Request $request, Video $video) {
        $request->validate(["title" => "required|string|max:255"]);
        if ($request->filled('video_url')) {
            $video->file_path = $request->video_url;
        } elseif ($request->hasFile("video")) {
            $file = $request->file("video");
            $filename = Str::slug($request->title) . "-" . Str::random(6) . "." . $file->getClientOriginalExtension();
            $video->file_path = $file->storeAs("media/videos", $filename, "r2");
        }
        $video->is_published = $request->boolean("is_published", true);
        $video->is_featured = $request->boolean("is_featured", false);
        $video->save();
        $trans = $video->translations()->where("locale", "en")->first();
        if ($trans) { $trans->update(["title" => $request->title]); }
        return redirect()->route("admin.videos.index")->with("success", "Video updated.");
    }
    
    public function destroy(Video $video) { $video->forceDelete(); return back()->with("success", "Deleted."); }
    public function togglePublish(Video $video) { $video->is_published = !$video->is_published; $video->save(); return back(); }
    public function toggleFeatured(Video $video) { $video->is_featured = !$video->is_featured; $video->save(); return back(); }
}
