<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderByDesc('created_at')->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.form', ['video' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'file'  => 'required|file|mimes:mp4,webm,mov,ogg,avi,mkv|max:102400',
        ]);

        $file = $request->file('file');
        $name = Str::slug($request->title);
        $ext = $file->getClientOriginalExtension();
        $filename = $name . '-' . Str::random(6) . '.' . $ext;
        $path = $file->storeAs('media/videos', $filename, 'public');

        $video = Video::create([
                        'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'is_published' => $request->boolean('is_published', true),
            'is_featured' => $request->boolean('is_featured', false),
        ]);

        $video->translations()->create([
            'locale' => 'en',
            'title' => $request->title,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video uploaded.');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        return view('admin.videos.form', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'file'  => 'nullable|file|mimes:mp4,webm,mov,ogg,avi,mkv|max:102400',
        ]);

        $data = [
                        'is_published' => $request->boolean('is_published', $video->is_published),
            'is_featured' => $request->boolean('is_featured', $video->is_featured),
        ];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($video->file_path);
            $file = $request->file('file');
            $name = Str::slug($request->title);
            $ext = $file->getClientOriginalExtension();
            $filename = $name . '-' . Str::random(6) . '.' . $ext;
            $path = $file->storeAs('media/videos', $filename, 'public');
            $data['file_path'] = $path;
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        $video->update($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video updated.');
    }

    public function destroy(Video $video)
    {
        Storage::disk('public')->delete($video->file_path);
        $video->delete();
        return back()->with('success', 'Video deleted.');
    }

    public function togglePublish(Video $video)
    {
        $video->is_published = ! $video->is_published;
        $video->save();
        return back()->with('success', $video->is_published ? 'Video published.' : 'Video unpublished.');
    }

    public function toggleFeatured(Video $video)
    {
        $video->is_featured = ! $video->is_featured;
        $video->save();
        return back()->with('success', $video->is_featured ? 'Video featured.' : 'Video unfeatured.');
    }
}
