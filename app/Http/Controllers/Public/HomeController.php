<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Photo;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        // Ideas: only featured + published
        $ideas = Idea::query()
            ->where('is_featured', true)
            ->where('is_published', true)
            ->with(['translations', 'category.translations'])
            ->latest()
            ->take(6)
            ->get();

        // Photos: ALL published (automatic)
        $photos = Photo::query()
            ->where('is_published', true)
            ->with('translations')
            ->latest()
            ->take(8)
            ->get();

        // Videos: ALL published (automatic)
        $videos = Video::query()
            ->where('is_published', true)
            ->with('translations')
            ->latest()
            ->take(6)
            ->get();

        return view('public.home', compact('ideas', 'photos', 'videos'));
    }
}
