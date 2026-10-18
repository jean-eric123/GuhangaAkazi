@extends('public.layouts.app')

@section('meta_title', ($t = $idea->translations->firstWhere('locale', 'en')) ? $t->title . ' — GuhangaAkazi' : $idea->slug)
@section('meta_description', $t?->short_description ?? '')

@section('content')
    <div class="container" style="padding:2rem 0;">
        {{-- Breadcrumb --}}
        <p style="font-size:.85rem; color:var(--text-muted); margin-bottom:1rem;">
            <a href="{{ route('public.ideas') }}" style="color:var(--text-muted);">Ideas</a> / {{ $t?->title ?? $idea->slug }}
        </p>

        <div class="idea-layout">
            {{-- LEFT: Content --}}
            <div class="idea-content">
                {{-- Cover image --}}
                @if ($idea->cover_image)
                    @php
                        $cover = preg_match('#^https?://#i', $idea->cover_image) ? $idea->cover_image : asset('storage/' . ltrim($idea->cover_image, '/'));
                    @endphp
                    <div class="idea-cover">
                        <img src="{{ $cover }}" alt="{{ $t?->title ?? $idea->slug }}">
                    </div>
                @endif

                {{-- Title + category --}}
                @if ($idea->category?->translation()?->name)
                    <span class="card-category" style="display:inline-block; margin-bottom:.5rem;">{{ $idea->category->translation()->name }}</span>
                @endif
                <h1 class="idea-title">{{ $t?->title ?? $idea->slug }}</h1>

                {{-- Short description --}}
                @if ($t?->short_description)
                    <p class="idea-short">{{ $t->short_description }}</p>
                @endif

                {{-- FULL DESCRIPTION — shown before money, as requested --}}
                @if ($t?->full_description)
                    <div class="idea-section">
                        <h2>About this idea</h2>
                        <p>{!! nl2br(e($t->full_description)) !!}</p>
                    </div>
                @endif

                {{-- Money box below full description --}}
                <div class="idea-money-box">
                    <h2>Money guide</h2>
                    <div class="idea-money-grid">
                        @if ($idea->capital)
                            <div class="idea-money-item">
                                <span>Starting capital</span>
                                <strong>{{ number_format($idea->capital, 0) . ' ' . $idea->currency }}</strong>
                            </div>
                        @endif
                        @if ($idea->expected_profit)
                            <div class="idea-money-item idea-money-highlight">
                                <span>Expected profit</span>
                                <strong>{{ number_format($idea->expected_profit, 0) . ' ' . $idea->currency }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Steps / Requirements / Tips --}}
                @if ($t?->steps)
                    <div class="idea-section"><h2>Steps</h2><p>{!! nl2br(e($t->steps)) !!}</p></div>
                @endif
                @if ($t?->requirements)
                    <div class="idea-section"><h2>Requirements</h2><p>{!! nl2br(e($t->requirements)) !!}</p></div>
                @endif
                @if ($t?->tips)
                    <div class="idea-section"><h2>Tips</h2><p>{!! nl2br(e($t->tips)) !!}</p></div>
                @endif

                {{-- Video if any --}}
                @if ($idea->video_url)
                    <div class="idea-section">
                        <h2>Video</h2>
                        <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:12px;">
                            @php
                                $url = trim($idea->video_url);
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $m)) {
                                    $videoSrc = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0';
                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
                                    $videoSrc = 'https://player.vimeo.com/video/' . $m[1];
                                } else {
                                    $videoSrc = $url;
                                }
                            @endphp
                            @if (str_contains($videoSrc, 'youtube') || str_contains($videoSrc, 'vimeo'))
                                <iframe src="{{ $videoSrc }}" style="position:absolute; inset:0; width:100%; height:100%;" frameborder="0" allowfullscreen></iframe>
                            @else
                                <video controls style="position:absolute; inset:0; width:100%; height:100%;"><source src="{{ $videoSrc }}" type="video/mp4"></video>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- RIGHT: sidebar with related photos --}}
            @php
                $photos = \App\Models\Photo::where('is_published', true)
                    ->whereHas('translations')
                    ->latest()->take(6)->get();
            @endphp
            @if ($photos->count() > 0)
                <aside class="idea-sidebar">
                    <h3>Photos</h3>
                    <div class="idea-photos-grid">
                        @foreach ($photos as $photo)
                            @php $pimg = preg_match('#^https?://#i', $photo->file_path) ? $photo->file_path : asset('storage/' . ltrim($photo->file_path, '/')); @endphp
                            <img src="{{ $pimg }}" alt="photo">
                        @endforeach
                    </div>
                </aside>
            @endif
        </div>
    </div>
@endsection
