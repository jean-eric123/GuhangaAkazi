@extends('admin.layouts.app')

@section('title', $title)
@section('page_title', $title)

@section('content')
    <h2 class="page-title">{{ $title }}</h2>
    <p class="page-subtitle">This module is under construction.</p>

    <div class="stat-card" style="text-align:center; padding:2.5rem 1rem">
        <p style="color:var(--text-muted); margin:0">The <strong>{{ $title }}</strong> module will be built in a later phase.</p>
    </div>
@endsection
