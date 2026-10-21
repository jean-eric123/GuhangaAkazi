<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\EngagementController;
Route::get("/", [HomeController::class, "index"])->name("public.home");
Route::get("/ideas", [PageController::class, "ideas"])->name("public.ideas"); Route::get("/ideas/{slug}", [PageController::class, "ideaDetail"])->name("public.ideas.show");
Route::get("/skills", [PageController::class, "skills"])->name("public.skills"); Route::get("/skills/{slug}", [PageController::class, "skillDetail"])->name("public.skills.show");
Route::get("/opportunities", [PageController::class, "opportunities"])->name("public.opportunities"); Route::get("/opportunities/{slug}", [PageController::class, "opportunityDetail"])->name("public.opportunities.show");
Route::get("/articles", [PageController::class, "articles"])->name("public.articles"); Route::get("/articles/{slug}", [PageController::class, "articleDetail"])->name("public.articles.show");
Route::get("/photos", [PageController::class, "photos"])->name("public.photos"); Route::get("/videos", [PageController::class, "videos"])->name("public.videos");
Route::get("/about", [PageController::class, "about"])->name("public.about"); Route::get("/mission", [PageController::class, "mission"])->name("public.mission"); Route::get("/vision", [PageController::class, "vision"])->name("public.vision");
Route::get("/contact", [PageController::class, "contact"])->name("public.contact"); Route::post("/contact", [PageController::class, "submitContact"])->name("public.contact.submit");
Route::get("/privacy", [PageController::class, "privacy"])->name("public.privacy"); Route::get("/terms", [PageController::class, "terms"])->name("public.terms"); Route::get("/search", [PageController::class, "search"])->name("public.search");
Route::post("/{type}/{id}/like", [EngagementController::class, "toggleLike"])->name("public.like"); Route::post("/{type}/{id}/comment", [EngagementController::class, "addComment"])->name("public.comment");