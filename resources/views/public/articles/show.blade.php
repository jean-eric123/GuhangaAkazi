@extends("public.layouts.app")
@section("content")
<div style="max-width: 800px; margin: 4rem auto; padding: 0 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem; line-height: 1.2;">{{ $article->translations->first()?->title ?? 'Article' }}</h1>
    
    <p style="font-size: 1.2rem; color: #64748b; margin-bottom: 2rem; font-style: italic; line-height: 1.6;">
        {{ $article->translations->first()?->summary ?? '' }}
    </p>
    
    @if($article->image_path ?? $article->image ?? false)
    <img src="{{ Storage::disk('r2')->url($article->image_path ?? $article->image) }}" style="width: 100%; border-radius: 12px; margin-bottom: 2rem; object-fit: cover; max-height: 400px; border: 1px solid #e2e8f0;">
    @endif
    
    <div style="line-height: 1.8; font-size: 1.15rem; color: #334155; margin-bottom: 2rem;">
        {!! nl2br(e($article->translations->first()?->body ?? '')) !!}
    </div>
    
    <!-- Engagement Section (Views, Likes, Comments) -->
    @include('public.partials.engagement', ['type' => 'post', 'item' => $article])
</div>
@endsection