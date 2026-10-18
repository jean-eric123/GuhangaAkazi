@extends("public.layouts.app")

@section("content")
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem;">Skills</h1>
        <p style="color: #6b7280; font-size: 1.1rem;">Learn practical skills to start your business.</p>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($skills->isEmpty())
            <div class="text-center" style="padding: 4rem 0;">
                <h2 style="font-size: 1.5rem; color: #6b7280;">No skills available yet.</h2>
            </div>
        @else
            <div class="grid-cards">
                @foreach($skills as $skill)
                    <div class="card">
                        <a href="{{ route('public.skills.show', $skill->slug ?? $skill->id) }}">
                            @php
                                $img = $skill->cover_image;
                                $src = $img ? (str_starts_with($img, "http") ? $img : asset("storage/" . $img)) : null;
                            @endphp
                            @if($src)
                                <img src="{{ $src }}" class="card-img" loading="lazy">
                            @else
                                <div class="card-img"></div>
                            @endif
                        </a>
                        <div class="card-body">
                            <h3 class="card-title"><a href="{{ route('public.skills.show', $skill->slug ?? $skill->id) }}" style="text-decoration:none; color:inherit;">{{ $skill->title ?? 'Untitled Skill' }}</a></h3>
                            @if($skill->description)
                                <p class="card-text">{{ Str::limit($skill->description, 80) }}</p>
                            @endif
                            <a href="{{ route('public.skills.show', $skill->slug ?? $skill->id) }}" style="display:inline-block; margin-top:0.5rem; color:#0B6B4F; font-weight:700; text-decoration:underline;">Read more...</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $skills->links() }}
            </div>
        @endif
    </div>
</div>
@endsection