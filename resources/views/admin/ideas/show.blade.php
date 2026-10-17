@extends('admin.layouts.app')

@section('title', 'View Idea')
@section('page_title', 'View Idea')

@section('content')
    @php($en = $idea->translations->firstWhere('locale', 'en'))

    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem; flex-wrap:wrap; gap:.75rem">
        <div>
            <h2 class="page-title" style="margin-bottom:.25rem">{{ $en?->title ?? $idea->slug }}</h2>
            <p class="page-subtitle" style="margin:0">
                <code>{{ $idea->slug }}</code>
                · {{ $idea->category?->translation()?->name ?? 'No category' }}
                · {{ $idea->is_published ? 'Published' : 'Draft' }}
                @if ($idea->is_featured) · ★ Featured @endif
            </p>
        </div>
        <div style="display:flex; gap:.5rem; flex-wrap:wrap">
            <a href="{{ route('admin.ideas.index') }}" style="padding:.5rem .9rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text); font-size:.85rem">← Back</a>
            <a href="{{ route('admin.ideas.edit', $idea) }}" style="background:var(--brand); color:#fff; padding:.5rem .9rem; border-radius:8px; text-decoration:none; font-weight:600; font-size:.85rem">Edit</a>
            <form method="POST" action="{{ route('admin.ideas.destroy', $idea) }}" onsubmit="return confirm('Delete this idea permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:#dc2626; color:#fff; border:0; padding:.5rem .9rem; border-radius:8px; font-weight:600; font-size:.85rem; cursor:pointer">Delete</button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
    @if ($idea->cover_image)
        <div style="margin-bottom:1.5rem; background:#fff; border:1px solid var(--border); border-radius:12px; padding:1rem">
            <h3 style="margin:0 0 .5rem; font-size:.95rem">Cover image</h3>
            <img
                src="{{ $idea->cover_image
    ? (preg_match("#^https?://#i", $idea->cover_image) ? $idea->cover_image : asset("storage/" . ltrim($idea->cover_image, "/")))
    : null }}"
                alt="{{ $idea->slug }} cover"
                style="width:100%; max-width:480px; height:auto; border-radius:8px; border:1px solid var(--border)">
        </div>
    @endif
<div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr))">
        <div style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:1rem">
            <h3 style="margin:0 0 .5rem; font-size:.95rem">Public info</h3>
            <p style="margin:.25rem 0"><strong>Starting capital:</strong> {{ $idea->capital ? number_format($idea->capital, 0) . ' ' . $idea->currency : '—' }}</p>
            <p style="margin:.25rem 0"><strong>Expected profit:</strong> {{ $idea->expected_profit ? number_format($idea->expected_profit, 0) . ' ' . $idea->currency : '—' }}</p>
        </div>
        <div style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:1rem">
            <h3 style="margin:0 0 .5rem; font-size:.95rem">Admin private</h3>
            <p style="margin:.25rem 0"><strong>Operating costs:</strong> {{ $idea->operating_costs ?? '—' }}</p>
            <p style="margin:.25rem 0"><strong>Expected revenue:</strong> {{ $idea->expected_revenue ?? '—' }}</p>
            <p style="margin:.25rem 0"><strong>Difficulty:</strong> {{ $idea->difficulty_level ?? '—' }}</p>
            <p style="margin:.25rem 0"><strong>Time to start:</strong> {{ $idea->time_to_start ?? '—' }}</p>
        </div>
    </div>

    <div style="margin-top:1.5rem; background:#fff; border:1px solid var(--border); border-radius:12px; padding:1rem">
        <h3 style="margin:0 0 .5rem; font-size:.95rem">Content</h3>
        <p style="margin:.25rem 0"><strong>Title:</strong> {{ $en?->title ?? '—' }}</p>
        <p style="margin:.25rem 0"><strong>Short:</strong> {{ $en?->short_description ?? '—' }}</p>
        <p style="margin:.25rem 0"><strong>Full:</strong> {!! nl2br(e($en?->full_description)) !!}</p>
        <p style="margin:.25rem 0"><strong>Steps:</strong> {!! nl2br(e($en?->steps)) !!}</p>
        <p style="margin:.25rem 0"><strong>Requirements:</strong> {!! nl2br(e($en?->requirements)) !!}</p>
        <p style="margin:.25rem 0"><strong>Tips:</strong> {!! nl2br(e($en?->tips)) !!}</p>
    </div>
@endsection
