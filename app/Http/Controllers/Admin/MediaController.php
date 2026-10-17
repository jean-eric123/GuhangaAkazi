<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Accept a cover image upload. Returns JSON with the public URL.
     */
    public function uploadCover(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',   // 10 MB
                'mimes:jpg,jpeg,png,webp,gif,bmp,svg,heic,heif,avif',
            ],
        ]);

        $file = $request->file('file');

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        if ($name === '') $name = 'image';
        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = $name . '-' . Str::random(8) . '.' . $ext;

        $path = $file->storeAs('media/covers', $filename, 'public');

        return response()->json([
            'ok'   => true,
            'path' => $path,
            'url'  => Storage::disk('public')->url($path),
        ]);
    }
}
