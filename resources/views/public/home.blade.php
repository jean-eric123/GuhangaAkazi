@extends("public.layouts.app")
@section("content")

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>Discover Business Ideas & Skills</h1>
            <p>Your journey to self-employment starts here. Explore practical ideas, learn new skills, and find opportunities in Rwanda.</p>
            <div class="hero-buttons">
                <a href="{{ route("public.ideas") }}" class="btn btn-primary">Explore Ideas</a>
            </div>
        </div>
    </div>
</section>

@if($featuredIdeas->isNotEmpty())
<section class="section py-5">
    <div class="container">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:end; margin-bottom:2rem;">
            <h2 style="font-size:1.5rem; font-weight:700;">Featured Business Ideas</h2>
            <a href="{{ route("public.ideas") }}" style="color:#0B6B4F; text-decoration:none; font-weight:600;">View all &rarr;</a>
        </div>
        <div class="grid-cards">
            @foreach($featuredIdeas as $idea)
                <div class="card">
                    <a href="{{ route("public.ideas.show", $idea->slug) }}">
                        @php $img = $idea->cover_image; $src = $img ? (str_starts_with($img, "http") ? $img : asset("storage/" . $img)) : null; @endphp
                        @if($src)
                            <img src="{{ $src }}" class="card-img" loading="lazy">
                        @else
                            <div class="card-img"></div>
                        @endif
                    </a>
                    <div class="card-body">
                        <h3 class="card-title"><a href="{{ route("public.ideas.show", $idea->slug) }}">{{ $idea->title ?? "Untitled Idea" }}</a></h3>
                        @if($idea->description)
                            <p class="card-text">{{ Str::limit($idea->description, 80) }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($photos->isNotEmpty())
<section class="section py-5 bg-light">
    <div class="container">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:end; margin-bottom:2rem;">
            <h2 style="font-size:1.5rem; font-weight:700;">Latest Photos</h2>
            <a href="{{ route("public.photos") }}" style="color:#0B6B4F; text-decoration:none; font-weight:600;">View all &rarr;</a>
        </div>
        <div class="grid-cards">
            @foreach($photos as $photo)
                <div class="card">
                    @php $img = $photo->file_path; $src = $img ? (str_starts_with($img, "http") ? $img : asset("storage/" . $img)) : null; @endphp
                    @if($src)
                        <img src="{{ $src }}" class="card-img" loading="lazy">
                    @else
                        <div class="card-img"></div>
                    @endif
                    <div class="card-body">
                        <h3 class="card-title">{{ $photo->title ?? "Untitled Photo" }}</h3>
                        @if($photo->description)
                            <p class="card-text">{{ Str::limit($photo->description, 80) }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($videos->isNotEmpty())
<section class="section py-5">
    <div class="container">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:end; margin-bottom:2rem;">
            <h2 style="font-size:1.5rem; font-weight:700;">Latest Videos</h2>
            <a href="{{ route("public.videos") }}" style="color:#0B6B4F; text-decoration:none; font-weight:600;">View all &rarr;</a>
        </div>
        <div class="grid-cards">
            @foreach($videos as $video)
                <div class="card">
                    @php $vid = $video->video_url ?? $video->file_path; $vidSrc = $vid ? (str_starts_with($vid, "http") ? $vid : asset("storage/" . $vid)) : null; @endphp
                    @if($vidSrc)
                        <video controls preload="none"><source src="{{ $vidSrc }}" type="video/mp4"></video>
                    @else
                        <div style="height:200px; background:#000; display:flex; align-items:center; justify-content:center; color:#fff;">No Video Available</div>
                    @endif
                    <div class="card-body">
                        <h3 class="card-title">{{ $video->title ?? "Untitled Video" }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="cta-section">
    <div class="container">
        <h2>Ready to start your journey?</h2>
        <p>Join thousands of Rwandans building businesses.</p>
        <a href="{{ route("public.skills") }}" class="cta-button">Get in Touch</a>
    </div>
</section>

@endsection