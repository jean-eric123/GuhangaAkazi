@extends('public.layouts.app')

@section('meta_title', 'GuhangaAkazi — Business Ideas, Skills & Opportunities')

@section('content')
    <section class="pub-hero">
        <div class="container">
            <div class="pub-hero-inner">
                <h1>Welcome to GuhangaAkazi</h1>
                <p>Discover business ideas, learn practical skills, and find opportunities to improve your life.</p>
                <a href="{{ route('public.ideas') }}" class="btn">Explore Ideas</a>
            </div>
        </div>
    </section>

    {{-- Featured Ideas --}}
    @if ($ideas->count() > 0)
        <section class="pub-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="pub-section-title">Featured Business Ideas</h2>
                    <a href="{{ route('public.ideas') }}" class="section-view-all">View all →</a>
                </div>
                <div class="grid-cards">
                    @foreach ($ideas as $idea)
                        @php
                            $t = $idea->translations->firstWhere('locale', 'en');
                            $img = $idea->cover_image
                                ? (preg_match('#^https?://#i', $idea->cover_image) ? $idea->cover_image : asset('storage/' . ltrim($idea->cover_image, '/')))
                                : null;
                        @endphp
                        <a href="{{ route('public.ideas.show', $idea->slug) }}" class="card card-idea">
                            @if ($img)
                                <div class="card-image-wrap">
                                    <img src="{{ $img }}" class="card-img" alt="{{ $t?->title ?? $idea->slug }}" loading="lazy">
                                </div>
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">{{ $t?->title ?? $idea->slug }}</h3>
                                <p class="card-desc">{{ $t?->short_description ?? '' }}</p>
                                <div class="card-money">
                                    @if ($idea->capital)
                                        <div class="money-row">
                                            <span class="money-label">Starting capital</span>
                                            <span class="money-value">{{ number_format($idea->capital, 0) . ' ' . $idea->currency }}</span>
                                        </div>
                                    @endif
                                    @if ($idea->expected_profit)
                                        <div class="money-row">
                                            <span class="money-label">Expected profit</span>
                                            <span class="money-value money-profit">{{ number_format($idea->expected_profit, 0) . ' ' . $idea->currency }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Photos --}}
    @if ($photos->count() > 0)
        <section class="pub-section" style="background:#f8faf9;">
            <div class="container">
                <div class="section-header">
                    <h2 class="pub-section-title">Photos</h2>
                    <a href="{{ route('public.photos') }}" class="section-view-all">View all →</a>
                </div>
                <div class="grid-photos-bordered">
                    @foreach ($photos as $photo)
                        @php
                            $pt = $photo->translations->firstWhere('locale', 'en');
                            $pimg = preg_match('#^https?://#i', $photo->file_path) ? $photo->file_path : asset('storage/' . ltrim($photo->file_path, '/'));
                        @endphp
                        <div class="photo-card-b">
                            <div class="photo-thumb-b">
                                <img src="{{ $pimg }}" alt="{{ $pt?->title ?? 'Photo' }}" loading="lazy">
                            </div>
                            <div class="photo-body-b">
                                <h3 class="photo-title-b">{{ $pt?->title ?? 'Untitled' }}</h3>
                                @if ($pt?->description)
                                    <p class="photo-desc-b">{{ $pt->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Videos --}}
    @if ($videos->count() > 0)
        <section class="pub-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="pub-section-title">Videos</h2>
                    <a href="{{ route('public.videos') }}" class="section-view-all">View all →</a>
                </div>
                <div class="grid-videos-bordered">
                    @foreach ($videos as $video)
                        @php
                            $vt = $video->translations->firstWhere('locale', 'en');
                            $vurl = preg_match('#^https?://#i', $video->file_path) ? $video->file_path : asset('storage/' . ltrim($video->file_path, '/'));
                        @endphp
                        <div class="video-card-b">
                            <div class="video-thumb-b">
                                <video controls preload="metadata">
                                    <source src="{{ $vurl }}" type="video/mp4">
                                </video>
                            </div>
                            <div class="video-body-b">
                                <h3 class="video-title-b">{{ $vt?->title ?? 'Video' }}</h3>
                                @if ($vt?->description)
                                    <p class="video-desc-b">{{ $vt->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
