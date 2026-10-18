<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Skill;
use App\Models\Opportunity;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function ideas(Request $request)
    {
        $query = Idea::with('translations');
        if (Schema::hasColumn("ideas", "is_published")) { $query->where("is_published", true); }
        $ideas = $query->latest()->paginate(12);
        return view("public.ideas.index", compact("ideas"));
    }

    public function ideaDetail($slug)
    {
        $idea = Idea::with('translations')->where("slug", $slug)->firstOrFail();
        return view("public.ideas.show", compact("idea"));
    }

    public function skills(Request $request)
    {
        $query = Skill::with('translations');
        if (Schema::hasColumn("skills", "is_published")) { $query->where("is_published", true); }
        $skills = $query->latest()->paginate(12);
        return view("public.skills.index", compact("skills"));
    }
    public function skillDetail($slug)
    {
        $skill = Skill::with('translations')->where("slug", $slug)->firstOrFail();
        return view("public.skills.show", compact("skill"));
    }

    public function opportunities(Request $request)
    {
        $query = Opportunity::with('translations');
        if (Schema::hasColumn("opportunities", "is_published")) { $query->where("is_published", true); }
        $opportunities = $query->latest()->paginate(12);
        return view("public.opportunities.index", compact("opportunities"));
    }
    public function opportunityDetail($slug)
    {
        $opportunity = Opportunity::with('translations')->where("slug", $slug)->firstOrFail();
        return view("public.opportunities.show", compact("opportunity"));
    }

    public function articles(Request $request)
    {
        $query = Post::query();
        if (Schema::hasColumn("posts", "is_published")) { $query->where("is_published", true); }
        $articles = $query->latest()->paginate(12);
        return view("public.articles.index", compact("articles"));
    }
    public function articleDetail($slug)
    {
        $article = Post::where("slug", $slug)->firstOrFail();
        return view("public.articles.show", compact("article"));
    }

    public function photos() { $photos = Photo::with("translations")->where("is_published", true)->latest()->paginate(12); return view("public.photos.index", compact("photos")); }
    public function videos() { $videos = Video::with("translations")->where("is_published", true)->latest()->paginate(12); return view("public.videos.index", compact("videos")); }
    public function about() { return view("public.placeholder", ["title" => "About Us"]); }
    public function contact() { return view("public.placeholder", ["title" => "Contact Us"]); }
    public function privacy() { return view("public.placeholder", ["title" => "Privacy Policy"]); }
    public function terms() { return view("public.placeholder", ["title" => "Terms of Service"]); }

    public function search(Request $request)
    {
        $q = $request->input('q');

        if (!$q) {
            if ($request->ajax()) {
                return response()->json(['html' => '<div style="text-align: center; padding: 3rem 0; color: #8e8e8e;"><div style="font-size: 1.1rem; font-weight: 600; color: #262626; margin-bottom: 0.25rem;">Search GuhangaAkazi</div><div>Type to find ideas, skills, and opportunities.</div></div>']);
            }
            return view("public.search");
        }

        $ideasQuery = Idea::with('translations')->whereHas('translations', function($query) use ($q) {
            $query->where('title', 'like', "%{$q}%");
        });
        if (Schema::hasColumn('ideas', 'is_published')) { $ideasQuery->where('is_published', true); }
        $ideas = $ideasQuery->latest()->get();

        $skillsQuery = Skill::with('translations')->whereHas('translations', function($query) use ($q) {
            $query->where('title', 'like', "%{$q}%");
        });
        if (Schema::hasColumn("skills", "is_published")) { $skillsQuery->where('is_published', true); }
        $skills = $skillsQuery->latest()->get();

        $oppsQuery = Opportunity::with('translations')->whereHas('translations', function($query) use ($q) {
            $query->where('title', 'like', "%{$q}%");
        });
        if (Schema::hasColumn("opportunities", "is_published")) { $oppsQuery->where('is_published', true); }
        $opportunities = $oppsQuery->latest()->get();

        $videosQuery = Video::with('translations')->whereHas('translations', function($query) use ($q) {
            $query->where('title', 'like', "%{$q}%");
        });
        if (Schema::hasColumn("videos", "is_published")) { $videosQuery->where('is_published', true); }
        $videos = $videosQuery->latest()->get();

        if ($request->ajax()) {
            $html = view('public.partials.search-results', compact('q', 'ideas', 'skills', 'opportunities', 'videos'))->render();
            return response()->json(['html' => $html]);
        }

        return view("public.search", compact('q', 'ideas', 'skills', 'opportunities', 'videos'));
    }
}
