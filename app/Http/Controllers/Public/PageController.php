<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\Skill;
use App\Models\Opportunity;
use App\Models\Post;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Setting;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function ideas() { 
        $ideas = Idea::with("translations")->latest()->paginate(12); 
        return view("public.ideas.index", compact("ideas")); 
    }

    public function ideaDetail($slug) { 
        $idea = Idea::with("translations")->where("slug", $slug)->firstOrFail(); 
        try { DB::table('page_views')->insert(['viewable_id' => $idea->id, 'viewable_type' => 'App\Models\Idea', 'created_at' => now(), 'updated_at' => now()]); } catch (\Exception $e) {}
        return view("public.ideas.show", compact("idea")); 
    }

    public function skills() { 
        $skills = Skill::with("translations")->latest()->paginate(12); 
        return view("public.skills.index", compact("skills")); 
    }

    public function skillDetail($slug) { 
        $skill = Skill::with("translations")->where("slug", $slug)->firstOrFail(); 
        try { DB::table('page_views')->insert(['viewable_id' => $skill->id, 'viewable_type' => 'App\Models\Skill', 'created_at' => now(), 'updated_at' => now()]); } catch (\Exception $e) {}
        return view("public.skills.show", compact("skill")); 
    }

    public function opportunities() { 
        $opportunities = Opportunity::with("translations")->latest()->paginate(12); 
        return view("public.opportunities.index", compact("opportunities")); 
    }

    public function opportunityDetail($slug) { 
        $opportunity = Opportunity::with("translations")->where("slug", $slug)->firstOrFail(); 
        try { DB::table('page_views')->insert(['viewable_id' => $opportunity->id, 'viewable_type' => 'App\Models\Opportunity', 'created_at' => now(), 'updated_at' => now()]); } catch (\Exception $e) {}
        return view("public.opportunities.show", compact("opportunity")); 
    }

    public function articles() { 
        $articles = Post::with("translations")->latest()->paginate(12); 
        return view("public.articles.index", compact("articles")); 
    }

    public function articleDetail($slug) { 
        $article = Post::with("translations")->where("slug", $slug)->firstOrFail(); 
        try { DB::table('page_views')->insert(['viewable_id' => $article->id, 'viewable_type' => 'App\Models\Post', 'created_at' => now(), 'updated_at' => now()]); } catch (\Exception $e) {}
        return view("public.articles.show", compact("article")); 
    }

    public function photos() { 
        // REMOVED is_published filter so admin uploads show instantly
        $photos = Photo::with("translations")->latest()->paginate(12); 
        return view("public.photos.index", compact("photos")); 
    }

    public function videos() { 
        // REMOVED is_published filter so admin uploads show instantly
        $videos = Video::with("translations")->latest()->paginate(12); 
        return view("public.videos.index", compact("videos")); 
    }

    public function about() { 
        $settings = Setting::pluck("value", "key")->all(); 
        return view("public.about", compact("settings")); 
    }

    public function mission() { return view("public.mission"); }
    public function vision() { return view("public.vision"); }

    public function contact() { 
        $settings = Setting::pluck("value", "key")->all(); 
        return view("public.contact", compact("settings")); 
    }

    public function privacy() { 
        $settings = Setting::pluck("value", "key")->all(); 
        return view("public.privacy", compact("settings")); 
    }

    public function terms() { 
        $settings = Setting::pluck("value", "key")->all(); 
        return view("public.terms", compact("settings")); 
    }

    public function submitContact(Request $request) { 
        $request->validate(["name" => "required", "email" => "required|email", "message" => "required"]); 
        ContactMessage::create($request->only("name", "email", "message")); 
        return back()->with("success", "Message sent!"); 
    }

    public function search(Request $request) { 
        $q = $request->input("q"); 
        if (!$q) { return view("public.search"); } 
        
        $ideas = Idea::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get(); 
        $skills = Skill::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get(); 
        $opportunities = Opportunity::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get(); 
        $posts = Post::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get(); 
        $photos = Photo::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get(); 
        $videos = Video::whereHas("translations", fn($q2) => $q2->where("title", "like", "%{$q}%"))->latest()->get(); 
        
        if ($request->ajax()) { 
            return response()->json(["html" => view("public.partials.search-results", compact("q", "ideas", "skills", "opportunities", "posts", "photos", "videos"))->render()]); 
        } 
        return view("public.search", compact("q", "ideas", "skills", "opportunities", "posts", "photos", "videos")); 
    }
}