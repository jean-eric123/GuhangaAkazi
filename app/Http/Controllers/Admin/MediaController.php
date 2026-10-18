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

    public function uploadVideos(Request $request)
    {
        try {
            $request->validate([
                'files' => 'required|array|min:1',
                'files.*' => 'file|max:102400|mimes:mp4,webm,mov,ogg,avi,mkv',
            ]);

            $results = [];
            foreach ($request->file('files') as $file) {
                $name = \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                if ($name === '') $name = 'video';
                $ext = strtolower($file->getClientOriginalExtension() ?: 'mp4');
                $filename = $name . '-' . \Str::random(8) . '.' . $ext;

                $path = $file->storeAs('media/videos', $filename, 'public');

                $video = \App\Models\Video::create([
                    'file_path' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'source_type' => 'upload',
                    'is_published' => false,
                    'is_featured' => false,
                ]);

                $video->translations()->create([
                    'locale' => 'en',
                    'title' => $name,
                ]);

                $results[] = [
                    'id' => $video->id,
                    'url' => \Storage::disk('public')->url($path),
                    'name' => $name,
                ];
            }

            return response()->json(['ok' => true, 'videos' => $results]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function uploadVideoChunk(Request $request)
    {
        $request->validate([
            'chunk' => 'required|file|max:4096', // 1MB limit per chunk
            'fileId' => 'required|string',
            'fileName' => 'required|string',
            'chunkIndex' => 'required|integer',
            'totalChunks' => 'required|integer',
        ]);

        $fileId = $request->input('fileId');
        $fileName = $request->input('fileName');
        $chunkIndex = (int) $request->input('chunkIndex');
        $totalChunks = (int) $request->input('totalChunks');

        $tempDir = storage_path('app/chunks/' . $fileId);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Save the chunk
        $chunkPath = $tempDir . '/' . $chunkIndex;
        $request->file('chunk')->move($tempDir, $chunkIndex);

        // Check if all chunks are uploaded
        $uploadedChunks = count(glob($tempDir . '/*'));
        
        if ($uploadedChunks === $totalChunks) {
            // Combine chunks
            $finalFileName = \Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . \Str::random(8) . '.mp4';
            $finalPath = 'media/videos/' . $finalFileName;
            $finalFullPath = storage_path('app/public/' . $finalPath);

            $out = fopen($finalFullPath, 'wb');
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = $tempDir . '/' . $i;
                $in = fopen($chunkFile, 'rb');
                while ($buff = fread($in, 4096)) {
                    fwrite($out, $buff);
                }
                fclose($in);
                unlink($chunkFile); // Delete chunk
            }
            fclose($out);
            rmdir($tempDir); // Delete temp dir

            // Save to database
            $video = \App\Models\Video::create([
                'file_path' => $finalPath,
                'original_filename' => $fileName,
                'file_size' => filesize($finalFullPath),
                'mime_type' => 'video/mp4',
                'source_type' => 'upload',
                'is_published' => false,
                'is_featured' => false,
            ]);

            $video->translations()->create([
                'locale' => 'en',
                'title' => pathinfo($fileName, PATHINFO_FILENAME),
            ]);

            return response()->json([
                'ok' => true,
                'complete' => true,
                'video' => [
                    'id' => $video->id,
                    'url' => \Storage::disk('public')->url($finalPath),
                    'name' => pathinfo($fileName, PATHINFO_FILENAME),
                ]
            ]);
        }

        return response()->json(['ok' => true, 'complete' => false]);
    }
}
