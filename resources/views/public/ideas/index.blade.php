@extends('public.layouts.app')

@section('meta_title', 'Business Ideas — GuhangaAkazi')

@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Business Ideas</h1>
            <p class="page-subtitle">Browse all published business ideas to start your own business.</p>
        </div>
    </div>

    <div class="container" style="padding:2rem 0;">
        @if ($ideas->count() === 0)
            <p style="text-align:center; color:var(--text-muted); padding:3rem 1rem;">No ideas published yet. Check back soon.</p>
        @else
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
                            @if ($idea->category?->translation()?->name)
                                <span class="card-category">{{ $idea->category->translation()->name }}</span>
                            @endif
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

            <div style="margin-top:2rem;">{{ $ideas->links() }}</div>
        @endif
    </div>
@endsection
