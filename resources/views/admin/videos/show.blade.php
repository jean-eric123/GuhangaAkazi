@extends('admin.layouts.app')
@section('title', 'View Video')
@section('page_title', 'View Video')
@section('content')
    <div style="display:flex; justify-content:space-between; margin-bottom:1rem; flex-wrap:wrap; gap:.5rem;">
        <h2 class="page-title" style="margin:0;">{{ $video->title }}</h2>
        <div style="display:flex; gap:.5rem;">
            <a href="{{ route('admin.videos.index') }}" style="padding:.5rem .9rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text);">← Back</a>
            <a href="{{ route('admin.videos.edit', $video) }}" style="background:var(--brand); color:#fff; padding:.5rem .9rem; border-radius:8px; text-decoration:none; font-weight:600;">Edit</a>
        </div>
    </div>

    <div style="background:#fff; border-radius:12px; padding:1rem;">
        @php
            $url = preg_match('#^https?://#i', $video->file_path) ? $video->file_path : asset('storage/' . ltrim($video->file_path, '/'));
        @endphp
        <video controls style="width:100%; max-height:480px; border-radius:8px; display:block; background:#000;">
            <source src="{{ $url }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div style="margin-top:1rem; font-size:.85rem; color:var(--text-muted);">
            <p><strong>Status:</strong> {{ $video->is_published ? 'Published' : 'Draft' }}</p>
            <p><strong>Featured:</strong> {{ $video->is_featured ? 'Yes' : 'No' }}</p>
            <p><strong>File:</strong> {{ basename($video->file_path) }}</p>
        </div>
    </div>
@endsection
