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
        $featuredIdeas = Idea::with("translations")
            ->where("is_featured", true)
            ->where("is_published", true)
            ->latest()
            ->take(6)
            ->get();

        $photos = Photo::with("translations")
            ->where("is_published", true)
            ->latest()
            ->take(6)
            ->get();

        $videos = Video::with("translations")
            ->where("is_published", true)
            ->latest()
            ->take(6)
            ->get();

        return view("public.home", compact("featuredIdeas", "photos", "videos"));
    }
}
