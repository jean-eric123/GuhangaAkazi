@extends('public.layouts.app')

@section('content')
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <div style="margin-bottom: 1rem;"><a href="{{ route('public.opportunities') }}" style="color: #0B6B4F; text-decoration: none; font-weight: 500;">&larq; Back to Opportunities</a></div>
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem; line-height: 1.2;">{{ $opportunity->title ?? 'Untitled Opportunity' }}</h1>
    </div>
</div>
<div class="section">
    <div class="container grid-detail">
        <div class="main-content">
            @if($opportunity->cover_image)<img src="{{ asset('storage/' . $opportunity->cover_image) }}" style="width: 100%; border-radius: 0.5rem; margin-bottom: 2rem; object-fit: cover; max-height: 400px;">@endif
            <div style="font-size: 1.1rem; line-height: 1.7; color: #374151;">{{ nla2br($opportunity->description ?? 'No description provided yet.') }}</div>
        </div>
        <div class="sidebar-content"><div class="card" style="padding: 1.5rem; background: #f0fdf4; border: 1px solid #dcfce7;"><h3 style="margin-top: 0; color: #064e3b; font-size: 1.25rem;">Apply Now</h3><p>This opportunity is waiting for you.</p><a href="{{ route('public.contact') }}" class="btn btn-primary" style="width:100%;">Contact Us</a></div></div>
    </div>
</div>
@stop