@extends('public.layouts.app')

@section('content')
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem;">Articles</h1>
        <p style="color: #6b7280; font-size: 1.1rem;">Insights, guides, and news for entrepreneurs.</p>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($articles->isEmpty())
            <div class="text-center" style="padding: 4rem 0;"><h2>No articles available yet.</h2></div>
        @else
            <div class="grid-cards">
                @foreach($articles as $article)
                    <div class="card">
                        <a href="{{ route('public.articles.show', $article->slug ?? $article->id) }}">
                            @if($article->cover_image)
                                <img src="{{ Storage::disk('r2')->url($article->cover_image) }}" class="card-img">
                            @else
                                <div class="card-img-placeholder"></div>
                            @endif
                        </a>
                        <div class="card-body">
                            <h3 class="card-title"><a href="{{ route('public.articles.show', $article->slug ?? $article->id) }}">{{ $article->title ?? 'Untitled Article' }}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@stop