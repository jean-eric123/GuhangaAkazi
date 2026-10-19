@extends("public.layouts.app")

@section("content")
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <div style="margin-bottom: 1rem;">
            <a href="{{ route("public.skills") }}" style="color: #0B6B4F; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Skills
            </a>
        </div>
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem; line-height: 1.2;">{{ $skill->title ?? "Untitled Skill" }}</h1>
    </div>
</div>
<div class="section">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        @php
            $img = $skill->cover_image;
            $src = $img ? (str_starts_with($img, "http") ? $img : Storage::disk("r2")->url($img)) : null;
        @endphp
        @if($src)
            <img src="{{ $src }}" style="width: 100%; border-radius: 0.5rem; margin-bottom: 2rem; object-fit: cover; max-height: 400px;" onerror="this.src='https://via.placeholder.com/600x400?text=Image+Not+Available'">
        @endif

        <div style="font-size: 1.15rem; line-height: 1.8; color: #374151;">
            {!! nl2br(e($skill->description ?? "No description provided yet.")) !!}
        </div>
    </div>
</div>
@endsection