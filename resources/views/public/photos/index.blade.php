@extends('public.layouts.app')
@section('meta_title', 'Photos — GuhangaAkazi')
@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Photos</h1>
            <p class="page-subtitle">Browse all published photos.</p>
        </div>
    </div>
    <div class="container" style="padding-top:2.5rem; padding-bottom:3rem;">
        @if ($photos->count() === 0)
            <p style="text-align:center; color:var(--text-muted);">No photos yet.</p>
        @else
            <div class="media-grid">
                @foreach ($photos as $photo)
                    @php
                        $pt = $photo->translations->firstWhere('locale', 'en');
                        $pimg = preg_match('#^https?://#i', $photo->file_path) ? $photo->file_path : asset('storage/' . ltrim($photo->file_path, '/'));
                    @endphp
                    <div class="media-card">
                        <div class="media-image"><img src="{{ $pimg }}" alt="{{ $pt?->title ?? 'Photo' }}" loading="lazy"></div>
                        <div class="media-body">
                            <h3 class="media-title">{{ $pt?->title ?? 'Untitled Photo' }}</h3>
                            @if ($pt?->description)<p class="media-desc">{{ $pt->description }}</p>@endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top:2rem;">{{ $photos->links() }}</div>
        @endif
    </div>
@endsection
