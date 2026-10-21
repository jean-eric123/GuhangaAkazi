<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    public function index() { $posts = Post::with("translations")->latest()->paginate(15); return view("admin.articles.index", compact("posts")); }
    public function create() { return view("admin.articles.form"); }
    public function store(Request $request) {
        $path = $request->input("cover_image_url") ?? ($request->hasFile("cover_image") ? $request->file("cover_image")->store("articles", "r2") : null);
        $post = Post::create(["slug" => Str::slug($request->title)."-".Str::random(5), "cover_image" => $path, "is_published" => $request->boolean("is_published", true)]);
        $post->translations()->create(["locale" => "en", "title" => $request->title, "summary" => $request->description]);
        return redirect()->route("admin.posts.index")->with("success", "Article created.");
    }
    public function edit(Post $post) { $post->load("translations"); return view("admin.articles.form", compact("post")); }
    public function update(Request $request, Post $post) {
        if ($request->hasFile("cover_image")) $post->cover_image = $request->file("cover_image")->store("articles", "r2");
        $post->save();
        $trans = $post->translations()->where("locale", "en")->first();
        if ($trans) { $trans->update(["title" => $request->title, "summary" => $request->description]); }
        return redirect()->route("admin.posts.index")->with("success", "Article updated.");
    }
    public function destroy(Post $post) { $post->forceDelete(); return back()->with("success", "Deleted."); }
}