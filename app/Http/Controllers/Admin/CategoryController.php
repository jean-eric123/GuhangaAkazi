<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index() { $categories = Category::latest()->paginate(15); return view("admin.categories.index", compact("categories")); }
    public function create() { return view("admin.categories.form"); }
    public function store(Request $request) {
        $cat = Category::create(["slug" => Str::slug($request->title)."-".Str::random(5), "type" => $request->type ?? "idea"]);
        if(method_exists($cat, "translations")) { $cat->translations()->create(["locale" => "en", "name" => $request->title]); }
        return redirect()->route("admin.categories.index")->with("success", "Category created.");
    }
    public function edit(Category $category) { return view("admin.categories.form", compact("category")); }
    public function update(Request $request, Category $category) {
        $category->slug = Str::slug($request->title)."-".Str::random(5);
        $category->save();
        if(method_exists($category, "translations")) { $category->translations()->updateOrCreate(["locale" => "en"], ["name" => $request->title]); }
        return redirect()->route("admin.categories.index")->with("success", "Category updated.");
    }
    public function destroy(Category $category) { $category->forceDelete(); return back()->with("success", "Category deleted."); }
}