@extends('public.layouts.app')
@section('meta_title', 'Videos — GuhangaAkazi')
@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Videos</h1>
            <p class="page-subtitle">Watch videos about ideas, skills and opportunities.</p>
        </div>
    </div>
    <div class="container" style="padding-top:2.5rem; padding-bottom:3rem;">
        @if ($videos->count() === 0)
            <p style="text-align:center; color:var(--text-muted);">No videos yet.</p>
        @else
            <div class="media-grid">
                @foreach ($videos as $video)
                    @php
                        $vt = $video->translations->firstWhere('locale', 'en');
                        $vurl = preg_match('#^https?://#i', $video->file_path) ? $video->file_path : asset('storage/' . ltrim($video->file_path, '/'));
                    @endphp
                    <div class="media-card">
                        <div class="media-image"><video controls preload="metadata"><source src="{{ $vurl }}" type="video/mp4"></video></div>
                        <div class="media-body">
                            <h3 class="media-title">{{ $vt?->title ?? 'Untitled Video' }}</h3>
                            @if ($vt?->description)<p class="media-desc">{{ $vt->description }}</p>@endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top:2rem;">{{ $videos->links() }}</div>
        @endif
    </div>
@endsection
