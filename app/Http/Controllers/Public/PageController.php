<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function ideas() { return view('public.placeholder', ['title' => 'Business Ideas']); }
    public function skills() { return view('public.placeholder', ['title' => 'Skills']); }
    public function opportunities() { return view('public.placeholder', ['title' => 'Opportunities']); }
    public function articles() { return view('public.placeholder', ['title' => 'Articles']); }
    public function photos() { return view('public.placeholder', ['title' => 'Photos']); }
    public function videos() { return view('public.placeholder', ['title' => 'Videos']); }
    public function about() { return view('public.placeholder', ['title' => 'About Us']); }
    public function contact() { return view('public.placeholder', ['title' => 'Contact Us']); }
    public function privacy() { return view('public.placeholder', ['title' => 'Privacy Policy']); }
    public function terms() { return view('public.placeholder', ['title' => 'Terms of Use']); }

    public function search(Request $request)
    {
        $q = trim((string) $request->get('q'));

        if ($q === '') {
            return view('public.search', ['q' => '', 'ideas' => collect(), 'photos' => collect(), 'videos' => collect()]);
        }

        $ideas = Idea::query()
            ->where('is_published', true)
            ->where(function ($query) use ($q) {
                $query->where('slug', 'like', "%{$q}%")
                    ->orWhereHas('translations', function ($t) use ($q) {
                        $t->where('title', 'like', "%{$q}%")
                          ->orWhere('short_description', 'like', "%{$q}%");
                    });
            })
            ->with('translations')
            ->limit(20)
            ->get();

        $photos = Photo::query()
            ->where('is_published', true)
            ->whereHas('translations', function ($t) use ($q) {
                $t->where('title', 'like', "%{$q}%");
            })
            ->limit(20)
            ->get();

        $videos = Video::query()
            ->where('is_published', true)
            ->where('title', 'like', "%{$q}%")
            ->limit(20)
            ->get();

        return view('public.search', compact('q', 'ideas', 'photos', 'videos'));
    }
}
