<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function uploadCover(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp,gif,bmp,svg,heic,heif,avif'],
        ]);

        $file = $request->file('file');
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        if ($name === '') { $name = 'image'; }
        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = $name . '-' . Str::random(8) . '.' . $ext;

        $path = $file->storeAs('media/covers', $filename, 'public');
        $this->compressImage(storage_path('app/public/' . $path));

        return response()->json([
            'ok' => true,
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    public function uploadPhotos(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'file|max:10240|mimes:jpg,jpeg,png,webp,gif,bmp,svg,heic,heif,avif',
        ]);

        $results = [];
        foreach ($request->file('files') as $file) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            if ($name === '') { $name = 'photo'; }
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = $name . '-' . Str::random(8) . '.' . $ext;

            $path = $file->storeAs('media/photos', $filename, 'public');
            $this->compressImage(storage_path('app/public/' . $path));

            $photo = Photo::create([
                'file_path'         => $path,
                'original_filename' => $file->getClientOriginalName(),
                'file_size'         => filesize(storage_path('app/public/' . $path)),
                'mime_type'         => $file->getMimeType(),
                'is_published'      => false,
                'is_featured'       => false,
            ]);

            $photo->translations()->create([
                'locale'      => 'en',
                'title'       => $name,
                'description' => null,
                'alt_text'    => $name,
            ]);

            $results[] = [
                'id'   => $photo->id,
                'url'  => Storage::disk('public')->url($path),
                'path' => $path,
                'name' => $name,
            ];
        }

        return response()->json(['ok' => true, 'photos' => $results]);
    }

    protected function compressImage(string $fullPath): void
    {
        if (! is_file($fullPath) || ! function_exists('imagecreatefromstring')) { return; }
        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        if (in_array($ext, ['svg','gif','avif','heic','heif'], true)) { return; }
        try {
            $data = file_get_contents($fullPath);
            if ($data === false || $data === '') { return; }
            $img = @imagecreatefromstring($data);
            if (! $img) { return; }
            $w = imagesx($img);
            $h = imagesy($img);
            $max = 1920;
            if ($w > $max || $h > $max) {
                $ratio = min($max / $w, $max / $h);
                $nw = (int) round($w * $ratio);
                $nh = (int) round($h * $ratio);
                $new = imagecreatetruecolor($nw, $nh);
                if ($ext === 'png') {
                    imagealphablening($new, false);
                    imagesavealpha($new, true);
                    $transparent = imagecolorallocatealpha($new, 255, 255, 255, 127);
                    imagefilledrectangle($new, 0, 0, $nw, $nh, $transparent);
                }
                imagecopyresampled($new, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);
                imagedestroy($img);
                $img = $new;
            }
            if ($ext === 'png') {
                @imagepng($img, $fullPath, 8);
            } elseif ($ext === 'webp') {
                @imagewebp($img, $fullPath, 80);
            } else {
                @imagejpeg($img, $fullPath, 80);
            }
            imagedestroy($img);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
