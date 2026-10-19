@extends('public.layouts.app')

@section('content')
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem;">Opportunities</h1>
        <p style="color: #6b7280; font-size: 1.1rem;">Find your next big break.</p>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($opportunities->isEmpty())
            <div class="text-center" style="padding: 4rem 0;"><h2>No opportunities available yet.</h2></div>
        @else
            <div class="grid-cards">
                @foreach($opportunities as $opp)
                    <div class="card">
                        <a href="{{ route('public.opportunities.show', $opp->slug ?? $opp->id) }}">
                            @if($opp->cover_image)<img src="{{ Storage::disk('r2')->url($opp->cover_image) }}" class="card-img">@else<div class="card-img-placeholder"></div>@endif
                        </a>
                        <div class="card-body">
                            <h3 class="card-title"><a href="{{ route('public.opportunities.show', $opp->slug ?? $opp->id) }}">{{ $opp->title ?? 'Untitled Opportunity' }}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 3rem; display: flex; justify-content: center;">{{ $opportunities->links() }}</div>
        @endif
    </div>
</div>
@stop