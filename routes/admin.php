<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdeaController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\OpportunityController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PhotoController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest:admin")->group(function () {
    Route::get("login", [LoginController::class, "showLoginForm"])->name("login");
    Route::post("login", [LoginController::class, "login"])->name("login.submit");
});

Route::middleware("admin")->group(function () {
    Route::post("logout", [LoginController::class, "logout"])->name("logout");
    Route::get("/", function () { return redirect()->route("admin.dashboard"); })->name("home");
    Route::get("dashboard", [DashboardController::class, "index"])->name("dashboard");
    
    // Ideas
    Route::post("ideas/{idea}/toggle-publish", [IdeaController::class, "togglePublish"])->name("ideas.toggle-publish");
    Route::post("ideas/{idea}/toggle-featured", [IdeaController::class, "toggleFeatured"])->name("ideas.toggle-featured");
    Route::resource("ideas", IdeaController::class);

    // Skills
    Route::resource("skills", SkillController::class);

    // Videos
    Route::post("videos/{video}/toggle-publish", [VideoController::class, "togglePublish"])->name("videos.toggle-publish");
    Route::post("videos/{video}/toggle-featured", [VideoController::class, "toggleFeatured"])->name("videos.toggle-featured");
    Route::resource("videos", VideoController::class);

    // Articles & Opportunities
    Route::resource("posts", PostController::class);
    Route::resource("opportunities", OpportunityController::class);
    Route::resource("photos", PhotoController::class);
    Route::resource("comments", CommentController::class);

    // Media
    Route::post("media/cover", [MediaController::class, "uploadCover"])->name("media.cover");
    Route::post("media/photos", [MediaController::class, "uploadPhotos"])->name("media.photos");
    Route::post("media/videos", [MediaController::class, "uploadVideos"])->name("media.videos");

    // Settings & Placeholders
    Route::get("settings", [SettingsController::class, "index"])->name("settings");
    Route::post("settings", [SettingsController::class, "update"])->name("settings.update");
    
    
    

    Route::resource("categories", App\Http\Controllers\Admin\CategoryController::class);
    Route::get("messages", [App\Http\Controllers\Admin\ContactMessageController::class, "index"])->name("messages");
    Route::delete("messages/{message}", [App\Http\Controllers\Admin\ContactMessageController::class, "destroy"])->name("messages.destroy");
    Route::get("profile", [App\Http\Controllers\Admin\ProfileController::class, "index"])->name("profile");
    Route::put("profile", [App\Http\Controllers\Admin\ProfileController::class, "update"])->name("profile.update");
    Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');

});