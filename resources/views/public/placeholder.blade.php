@extends('public.layouts.app')

@section('meta_title', $title . ' — GuhangaAkazi')

@section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 3rem; min-height: 50vh;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;">{{ $title }}</h1>
        <p style="color: var(--text-muted);">This page is being built. Content will appear here soon.</p>
        
        <div class="card" style="margin-top: 2rem;">
            <h2>Coming soon</h2>
            <p>We are building this section of the website.</p>
        </div>
    </div>
@endsection
