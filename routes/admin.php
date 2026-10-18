<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdeaController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware('admin')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('home');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('ideas/{idea}/toggle-publish',  [IdeaController::class, 'togglePublish'])->name('ideas.toggle-publish');
    Route::post('ideas/{idea}/toggle-featured', [IdeaController::class, 'toggleFeatured'])->name('ideas.toggle-featured');

    Route::resource('ideas', IdeaController::class);

    foreach ([
        'skills'        => 'Skills',
        'opportunities' => 'Opportunities',
        'articles'      => 'Articles',
        'photos'        => 'Photos',
        'videos'        => 'Videos',
        'categories'    => 'Categories',
        'comments'      => 'Comments',
        'messages'      => 'Contact Messages',
        'settings'      => 'Website Settings',
        'profile'       => 'Admin Profile',
    ] as $slug => $label) {
        Route::get($slug, function () use ($label) {
            return view('admin.placeholder.coming-soon', ['title' => $label]);
        })->name($slug);
    }
});

use App\Http\Controllers\Admin\MediaController;

Route::middleware('admin')->group(function () {
    Route::post('media/cover', [MediaController::class, 'uploadCover'])
        ->middleware('throttle:60,1')
        ->name('media.cover');
});

Route::middleware('admin')->group(function () {
    Route::post('media/photos', [App\Http\Controllers\Admin\MediaController::class, 'uploadPhotos'])
    ->middleware('throttle:30,1')
    ->name('media.photos');

Route::post('media/videos', [App\Http\Controllers\Admin\MediaController::class, 'uploadVideos']) 
        ->middleware('throttle:30,1')
        ->name('media.videos');
});

Route::middleware('admin')->group(function () {
    Route::post('media/video-chunk', [App\Http\Controllers\Admin\MediaController::class, 'uploadVideoChunk'])->name('media.video-chunk');
});

Route::middleware('admin')->group(function () {
    
    Route::post('videos/{video}/toggle-publish', [App\Http\Controllers\Admin\VideoController::class, 'togglePublish'])->name('videos.toggle-publish');
    Route::post('videos/{video}/toggle-featured', [App\Http\Controllers\Admin\VideoController::class, 'toggleFeatured'])->name('videos.toggle-featured');

    Route::resource('videos', App\Http\Controllers\Admin\VideoController::class);
});

Route::middleware('admin')->group(function () {
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});
