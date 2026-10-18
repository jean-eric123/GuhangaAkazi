<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('public.home');

Route::get('/ideas', [PageController::class, 'ideas'])->name('public.ideas');
Route::get('/skills', [PageController::class, 'skills'])->name('public.skills');
Route::get('/opportunities', [PageController::class, 'opportunities'])->name('public.opportunities');
Route::get('/articles', [PageController::class, 'articles'])->name('public.articles');
Route::get('/photos', [PageController::class, 'photos'])->name('public.photos');
Route::get('/videos', [PageController::class, 'videos'])->name('public.videos');

Route::get('/about', [PageController::class, 'about'])->name('public.about');
Route::get('/contact', [PageController::class, 'contact'])->name('public.contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('public.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('public.terms');

Route::get('/search', [PageController::class, 'search'])->name('public.search');
