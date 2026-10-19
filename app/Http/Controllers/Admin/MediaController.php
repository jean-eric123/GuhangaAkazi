<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function uploadCover(Request $request)
    {
        $request->validate(['file' => 'required|image|max:5120']);
        $path = $request->file('file')->store('media/covers', 'r2');
        return response()->json([
            'path' => $path,
            'url' => Storage::disk('r2')->url($path)
        ]);
    }

    public function uploadPhotos(Request $request)
    {
        $paths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('media/photos', 'r2');
                $paths[] = ['path' => $path, 'url' => Storage::disk('r2')->url($path)];
            }
        }
        return response()->json(['files' => $paths]);
    }

    public function uploadVideos(Request $request)
    {
        $path = $request->file('file')->store('media/videos', 'r2');
        return response()->json(['path' => $path, 'url' => Storage::disk('r2')->url($path)]);
    }
}