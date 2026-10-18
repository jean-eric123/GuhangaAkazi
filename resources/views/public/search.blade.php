@extends('public.layouts.app')

@section('meta_title', 'Search — GuhangaAkazi')

@section('content')
    <div class="container" style="padding-top:2.5rem; padding-bottom:3rem;">
        <h1 style="font-size:2rem; font-weight:800; margin:0 0 1rem;">Search Results</h1>

        <form action="{{ route('public.search') }}" method="GET" style="margin-bottom:2rem;">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search anything..."
                   class="pub-search-page-input">
        </form>

        @if ($q === '')
            <p style="color:var(--text-muted);">Type a keyword above to search ideas, photos, and videos.</p>
        @else
            <p style="color:var(--text-muted); margin-bottom:2rem;">
                Results for <strong>"{{ $q }}"</strong>:
                {{ $ideas->count() + $photos->count() + $videos->count() }} found
            </p>

            @if ($ideas->count() > 0)
                <h2 style="font-size:1.25rem; margin:2rem 0 .75rem;">Business Ideas ({{ $ideas->count() }})</h2>
                <ul style="padding-left:1.25rem;">
                    @foreach ($ideas as $idea)
                        @php($t = $idea->translations->firstWhere('locale', 'en'))
                        <li style="margin-bottom:.5rem;">{{ $t?->title ?? $idea->slug }}</li>
                    @endforeach
                </ul>
            @endif

            @if ($photos->count() > 0)
                <h2 style="font-size:1.25rem; margin:2rem 0 .75rem;">Photos ({{ $photos->count() }})</h2>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:1rem;">
                    @foreach ($photos as $photo)
                        <img src="{{ asset('storage/' . $photo->file_path) }}" style="width:100%; height:120px; object-fit:cover; border-radius:8px;">
                    @endforeach
                </div>
            @endif

            @if ($videos->count() > 0)
                <h2 style="font-size:1.25rem; margin:2rem 0 .75rem;">Videos ({{ $videos->count() }})</h2>
                <ul style="padding-left:1.25rem;">
                    @foreach ($videos as $video)
                        <li style="margin-bottom:.5rem;">{{ $video->title }}</li>
                    @endforeach
                </ul>
            @endif

            @if ($ideas->count() + $photos->count() + $videos->count() === 0)
                <p style="color:var(--text-muted);">No results found. Try different keywords.</p>
            @endif
        @endif
    </div>
@endsection
