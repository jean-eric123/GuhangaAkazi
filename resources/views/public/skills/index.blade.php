@extends('public.layouts.app')

@section('content')
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem;">Skills</h1>
        <p style="color: #6b7280; font-size: 1.1rem;">Learn practical skills to start your business.</p>
    </div>
</div>

<div class="section">
    <div class="container">
        @if($skills->isEmpty())
            <div class="text-center" style="padding: 4rem 0;"><h2>No skills available yet.</h2></div>
        @else
            <div class="grid-cards">
                @foreach($skills as $skill)
                    <div class="card">
                        <a href="{{ route('public.skills.show', $skill->slug ?? $skill->id) }}">
                            @if($skill->cover_image)
                                <img src="{{ asset('storage/' . $skill->cover_image) }}" class="card-img">
                            @else
                                <div class="card-img-placeholder"></div>
                            @endif
                        </a>
                        <div class="card-body">
                            <h3 class="card-title"><a href="{{ route('public.skills.show', $skill->slug ?? $skill->id) }}">{{ $skill->title ?? 'Untitled Skill' }}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 3rem; display: flex; justify-content: center;">{{ $skills->links() }}</div>
        @endif
    </div>
</div>
@stop