<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Video;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Skill;
use App\Models\Opportunity;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch latest items for ALL 6 categories
        $v = Video::latest()->take(4)->get();
        $i = Idea::latest()->take(4)->get();
        $p = Photo::latest()->take(4)->get();
        $articles = Post::latest()->take(4)->get();
        $skills = Skill::latest()->take(4)->get();
        $opportunities = Opportunity::latest()->take(4)->get();
        
        // Fetch Admin Settings (Social Media Links)
        $s = Setting::pluck('value', 'key')->all();

        return view('public.home', compact('v', 'i', 'p', 'articles', 'skills', 'opportunities', 's'));
    }
}