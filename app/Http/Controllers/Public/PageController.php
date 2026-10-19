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
    public function ideas(Request $request) {
        $query = Idea::with("translations");
        if (Schema::hasColumn("ideas", "is_published")) { $query->where("is_published", true); }
        $ideas = $query->latest()->paginate(12);
        return view("public.ideas.index", compact("ideas"));
    }
    public function ideaDetail($slug) {
        $idea = Idea::with("translations")->where("slug", $slug)->firstOrFail();
        return view("public.ideas.show", compact("idea"));
    }
    public function skills(Request $request) {
        $query = Skill::with("translations");
        if (Schema::hasColumn("skills", "is_published")) { $query->where("is_published", true); }
        $skills = $query->latest()->paginate(12);
        return view("public.skills.index", compact("skills"));
    }
    public function skillDetail($slug) {
        $skill = Skill::with("translations")->where("slug", $slug)->firstOrFail();
        return view("public.skills.show", compact("skill"));
    }
    public function opportunities(Request $request) {
        $query = Opportunity::with("translations");
        if (Schema::hasColumn("opportunities", "is_published")) { $query->where("is_published", true); }
        $opportunities = $query->latest()->paginate(12);
        return view("public.opportunities.index", compact("opportunities"));
    }
    public function opportunityDetail($slug) {
        $opportunity = Opportunity::with("translations")->where("slug", $slug)->firstOrFail();
        return view("public.opportunities.show", compact("opportunity"));
    }
    public function articles(Request $request) {
        $query = Post::with("translations");
        if (Schema::hasColumn("posts", "is_published")) { $query->where("is_published", true); }
        $articles = $query->latest()->paginate(12);
        return view("public.articles.index", compact("articles"));
    }
    public function articleDetail($slug) {
        $article = Post::with("translations")->where("slug", $slug)->firstOrFail();
        return view("public.articles.show", compact("article"));
    }
    public function photos() {
        $photos = Photo::with("translations")->where("is_published", true)->latest()->paginate(12);
        return view("public.photos.index", compact("photos"));
    }
    public function videos() {
        $videos = Video::with("translations")->where("is_published", true)->latest()->paginate(12);
        return view("public.videos.index", compact("videos"));
    }
    public function about() { return view("public.about"); }
    public function contact() { return view("public.placeholder", ["title" => "Contact Us"]); }
    public function privacy() { return view("public.placeholder", ["title" => "Privacy Policy"]); }
    public function terms() { return view("public.placeholder", ["title" => "Terms of Service"]); }

    public function search(Request $request) {
        $q = $request->input("q");
        if (!$q) {
            if ($request->ajax()) { return response()->json(["html" => "<div style=\"text-align:center; padding:3rem 0; color:#8e8e8e;\">Search GuhangaAkazi</div>"]); }
            return view("public.search");
        }

        try {
            $ideas = Idea::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get();
            $skills = Skill::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get();
            $opportunities = Opportunity::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get();
            $posts = Post::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get();
            $photos = Photo::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get();
            $videos = Video::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get();

            if ($request->ajax()) {
                $html = view("public.partials.search-results", compact("q", "ideas", "skills", "opportunities", "posts", "photos", "videos"))->render();
                return response()->json(["html" => $html]);
            }
            return view("public.search", compact("q", "ideas", "skills", "opportunities", "posts", "photos", "videos"));
        } catch (\Exception $e) {
            return response()->json(["html" => "<div style='color:red; padding:1rem;'>Search Error: " . $e->getMessage() . "</div>"]);
        }
    }
}