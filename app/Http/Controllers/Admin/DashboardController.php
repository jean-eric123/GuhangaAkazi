<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Idea;
use App\Models\Opportunity;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Video;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'ideas_total'        => Idea::count(),
            'ideas_published'    => Idea::where('is_published', true)->count(),
            'ideas_draft'        => Idea::where('is_published', false)->count(),

            'skills_total'       => Skill::count(),
            'skills_published'   => Skill::where('is_published', true)->count(),

            'opportunities_total'     => Opportunity::count(),
            'opportunities_published' => Opportunity::where('is_published', true)->count(),

            'posts_total'        => Post::count(),
            'posts_published'    => Post::where('is_published', true)->count(),

            'photos_total'       => Photo::count(),
            'videos_total'       => Video::count(),

            'categories_total'   => Category::count(),

            'messages_total'     => ContactMessage::count(),
            'messages_unread'    => ContactMessage::where('is_read', false)->count(),

            'settings_total'     => Setting::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
