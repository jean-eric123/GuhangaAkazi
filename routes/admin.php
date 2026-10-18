<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdeaController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SkillController;
use Illuminate\Support\Facades\Route;

// Guest routes (Login)
Route::middleware('guest:admin')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
});

// SECURE ADMIN ROUTES (Everything below is protected by the 'admin' middleware)
Route::middleware('admin')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', function () { return redirect()->route('admin.dashboard'); })->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ideas
    Route::post('ideas/{idea}/toggle-publish', [IdeaController::class, 'togglePublish'])->name('ideas.toggle-publish');
    Route::post('ideas/{idea}/toggle-featured', [IdeaController::class, 'toggleFeatured'])->name('ideas.toggle-featured');
    Route::resource('ideas', IdeaController::class);

    // Skills
    Route::resource('skills', SkillController::class);

    // Videos
    Route::post('videos/{video}/toggle-publish', [VideoController::class, 'togglePublish'])->name('videos.toggle-publish');
    Route::post('videos/{video}/toggle-featured', [VideoController::class, 'toggleFeatured'])->name('videos.toggle-featured');
    Route::resource('videos', VideoController::class);

    // Media
    Route::post('media/cover', [MediaController::class, 'uploadCover'])->name('media.cover');
    Route::post('media/photos', [MediaController::class, 'uploadPhotos'])->name('media.photos');
    Route::post('media/videos', [MediaController::class, 'uploadVideos'])->name('media.videos');
    Route::post('media/video-chunk', [MediaController::class, 'uploadVideoChunk'])->name('media.video-chunk');

    // Settings
    Route::resource('photos', App\Http\Controllers\Admin\PhotoController::class);
    Route::resource('photos', App\Http\Controllers\Admin\PhotoController::class);
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Placeholders (Now 100% secured)
    $placeholders = [
        'opportunities' => 'Opportunities',
        'articles' => 'Articles',
        
        'categories' => 'Categories',
        'comments' => 'Comments',
        'messages' => 'Contact Messages',
        'profile' => 'Admin Profile',
    ];
    foreach ($placeholders as $slug => $label) {
        Route::get($slug, function () use ($label) {
            return view('admin.placeholder.coming-soon', ['title' => $label]);
        })->name($slug);
    }
});
