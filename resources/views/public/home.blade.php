@extends("public.layouts.app")
@section("content")

<!-- Hero Section -->
<div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 5rem 1rem; text-align: center;">
    <h1 style="font-size: 3rem; font-weight: 900; color: #0f172a; margin-bottom: 1rem; letter-spacing: -1px;">
        Build Your Future with <span style="color: #0B6B4F;">GuhangaAkazi</span>
    </h1>
    <p style="font-size: 1.2rem; color: #475569; max-width: 600px; margin-left: auto; margin-right: auto;">
        Discover the best business ideas, skills, and opportunities to start your journey.
    </p>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 4rem 1rem;">

    <!-- 1. VIDEOS -->
    @if(isset($v) && $v->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Latest Videos</h2>
        <a href="{{ route('public.videos') }}" style="color: #0B6B4F; font-weight: 700; text-decoration: none;">View All &rarr;</a>
    </div>
    <div class="grid-cards" style="margin-bottom: 3rem;">
        @foreach($v as $video)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            <div style="position: relative; aspect-ratio: 16/9; background: #000;">
                @php $vFile = $video->file_path ?? false; @endphp
                @if($video->video_url)
                <iframe src="{{ $video->video_url }}" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                @elseif($vFile)
                <video controls style="width: 100%; height: 100%; object-fit: cover;">
                    <source src="{{ Str::startsWith($vFile, 'http') ? $vFile : Storage::disk('r2')->url($vFile) }}">
                </video>
                @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1e293b;">
                    <svg style="width: 48px; height: 48px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                @endif
            </div>
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $video->translations->first()?->title ?? 'Video' }}</h3>
                <div style="margin-top: auto;">@include('public.partials.engagement', ['type' => 'video', 'item' => $video])</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- 2. IDEAS -->
    @if(isset($i) && $i->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Featured Ideas</h2>
        <a href="{{ route('public.ideas') }}" style="color: #0B6B4F; font-weight: 700; text-decoration: none;">View All &rarr;</a>
    </div>
    <div class="grid-cards" style="margin-bottom: 3rem;">
        @foreach($i as $idea)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @php $img = $idea->file_path ?? $idea->image_path ?? false; @endphp
            @if($img)
                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::disk('r2')->url($img) }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @else
                <div style="width: 100%; aspect-ratio: 16/9; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 48px; height: 48px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $idea->translations->first()?->title ?? 'Idea' }}</h3>
                <a href="{{ route('public.ideas.show', $idea->slug) }}" style="margin-top: auto; color: #0B6B4F; font-weight: 700; text-decoration: none; margin-bottom: 1rem;">Read More &rarr;</a>
                @include('public.partials.engagement', ['type' => 'idea', 'item' => $idea])
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- 3. SKILLS -->
    @if(isset($skills) && $skills->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Top Skills</h2>
        <a href="{{ route('public.skills') }}" style="color: #0B6B4F; font-weight: 700; text-decoration: none;">View All &rarr;</a>
    </div>
    <div class="grid-cards" style="margin-bottom: 3rem;">
        @foreach($skills as $skill)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @php $img = $skill->file_path ?? $skill->image_path ?? false; @endphp
            @if($img)
                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::disk('r2')->url($img) }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @else
                <div style="width: 100%; aspect-ratio: 16/9; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 48px; height: 48px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $skill->translations->first()?->title ?? 'Skill' }}</h3>
                <a href="{{ route('public.skills.show', $skill->slug) }}" style="margin-top: auto; color: #0B6B4F; font-weight: 700; text-decoration: none; margin-bottom: 1rem;">Read More &rarr;</a>
                @include('public.partials.engagement', ['type' => 'skill', 'item' => $skill])
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- 4. OPPORTUNITIES -->
    @if(isset($opportunities) && $opportunities->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Opportunities</h2>
        <a href="{{ route('public.opportunities') }}" style="color: #0B6B4F; font-weight: 700; text-decoration: none;">View All &rarr;</a>
    </div>
    <div class="grid-cards" style="margin-bottom: 3rem;">
        @foreach($opportunities as $opportunity)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @php $img = $opportunity->file_path ?? $opportunity->image_path ?? false; @endphp
            @if($img)
                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::disk('r2')->url($img) }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @else
                <div style="width: 100%; aspect-ratio: 16/9; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 48px; height: 48px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $opportunity->translations->first()?->title ?? 'Opportunity' }}</h3>
                <a href="{{ route('public.opportunities.show', $opportunity->slug) }}" style="margin-top: auto; color: #0B6B4F; font-weight: 700; text-decoration: none; margin-bottom: 1rem;">View Details &rarr;</a>
                @include('public.partials.engagement', ['type' => 'opportunity', 'item' => $opportunity])
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- 5. ARTICLES -->
    @if(isset($articles) && $articles->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Latest Articles</h2>
        <a href="{{ route('public.articles') }}" style="color: #0B6B4F; font-weight: 700; text-decoration: none;">View All &rarr;</a>
    </div>
    <div class="grid-cards" style="margin-bottom: 3rem;">
        @foreach($articles as $article)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @php $img = $article->file_path ?? $article->image_path ?? false; @endphp
            @if($img)
                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::disk('r2')->url($img) }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @else
                <div style="width: 100%; aspect-ratio: 16/9; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 48px; height: 48px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $article->translations->first()?->title ?? 'Article' }}</h3>
                <a href="{{ route('public.articles.show', $article->slug) }}" style="margin-top: auto; color: #0B6B4F; font-weight: 700; text-decoration: none; margin-bottom: 1rem;">Read Article &rarr;</a>
                @include('public.partials.engagement', ['type' => 'post', 'item' => $article])
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- 6. PHOTOS -->
    @if(isset($p) && $p->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Latest Photos</h2>
        <a href="{{ route('public.photos') }}" style="color: #0B6B4F; font-weight: 700; text-decoration: none;">View All &rarr;</a>
    </div>
    <div class="grid-cards" style="margin-bottom: 3rem;">
        @foreach($p as $photo)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @php $img = $photo->file_path ?? $photo->image_path ?? false; @endphp
            @if($img)
                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::disk('r2')->url($img) }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @else
                <div style="width: 100%; aspect-ratio: 16/9; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 48px; height: 48px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $photo->translations->first()?->title ?? 'Photo' }}</h3>
                @include('public.partials.engagement', ['type' => 'photo', 'item' => $photo])
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection