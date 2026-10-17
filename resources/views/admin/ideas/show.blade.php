@extends('admin.layouts.app')
@section('title', 'View Idea')
@section('page_title', 'View Idea')

@section('content')
    @php($en = $idea->translations->firstWhere('locale', 'en'))

    <div style="margin-bottom:1rem">
        <a href="{{ route('admin.ideas.index') }}" style="color:var(--text-muted); text-decoration:none;">&larr; Back</a>
    </div>

    <h2 class="page-title">{{ $en?->title ?? $idea->slug }}</h2>

    <div style="display:flex; gap:.5rem; margin-bottom:1rem;">
        <a href="{{ route('admin.ideas.edit', $idea) }}" style="background:var(--brand); color:#fff; padding:.5rem .9rem; border-radius:8px; text-decoration:none;">Edit</a>
        <form method="POST" action="{{ route('admin.ideas.destroy', $idea) }}" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button type="submit" style="background:#dc2626; color:#fff; border:0; padding:.5rem .9rem; border-radius:8px;">Delete</button>
        </form>
    </div>

    @if ($idea->cover_image)
        <div style="margin-bottom:1rem;">
            <img src="{{ $idea->cover_image }}" style="max-width:100%; max-height: 400px; border-radius:8px; display:block; object-fit: cover;">
        </div>
    @endif

    <div style="background:#fff; padding:1rem; border-radius:12px; margin-bottom:1rem;">
        <h3>Money Info</h3>
        <p>Capital: {{ $idea->capital ? number_format($idea->capital, 0) . ' ' . $idea->currency : '—' }}</p>
        <p>Profit: {{ $idea->expected_profit ? number_format($idea->expected_profit, 0) . ' ' . $idea->currency : '—' }}</p>
    </div>

    <div style="background:#fff; padding:1rem; border-radius:12px;">
        <h3>Photos</h3>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(120px, 1fr)); gap:1rem;">
            @forelse ($photos as $photo)
                <div style="width:100%; aspect-ratio: 1 / 1; overflow:hidden; border-radius:8px; background:#f1f5f4; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <img src="{{ preg_match('#^https?://#i', $photo->file_path) ? $photo->file_path : asset('storage/' . ltrim($photo->file_path, '/')) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
            @empty
                <p style="color:var(--text-muted);">No photos yet.</p>
            @endforelse
        </div>
    </div>
@endsection