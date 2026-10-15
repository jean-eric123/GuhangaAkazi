@extends('admin.layouts.app')

@section('title', 'Business Ideas')
@section('page_title', 'Business Ideas')

@section('content')
    <div style="display:flex; flex-wrap:wrap; gap:.75rem; align-items:center; justify-content:space-between; margin-bottom:1rem">
        <div>
            <h2 class="page-title" style="margin-bottom:.25rem">Business Ideas</h2>
            <p class="page-subtitle" style="margin:0">Manage all business ideas.</p>
        </div>
        <a href="{{ route('admin.ideas.create') }}"
           style="background:var(--brand); color:#fff; padding:.6rem 1rem; border-radius:8px; text-decoration:none; font-weight:600; font-size:.9rem">
            + New Idea
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" style="display:flex; flex-wrap:wrap; gap:.5rem; margin-bottom:1.25rem">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title or slug"
               style="flex:1; min-width:180px; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
        <select name="category" style="padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            <option value="">All categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->translation()?->name ?? $cat->slug }}</option>
            @endforeach
        </select>
        <select name="status" style="padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            <option value="">All statuses</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
            <option value="draft"     @selected(request('status') === 'draft')>Draft</option>
            <option value="featured"  @selected(request('status') === 'featured')>Featured</option>
        </select>
        <button type="submit" style="background:var(--brand); color:#fff; border:0; padding:.55rem 1rem; border-radius:8px; font-weight:600; cursor:pointer">Filter</button>
        @if (request()->hasAny(['q', 'category', 'status']))
            <a href="{{ route('admin.ideas.index') }}" style="padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text); font-size:.9rem">Clear</a>
        @endif
    </form>

    @if ($ideas->isEmpty())
        <div class="stat-card" style="text-align:center; padding:2.5rem 1rem">
            <p style="color:var(--text-muted); margin:0 0 .5rem">No ideas yet.</p>
            <a href="{{ route('admin.ideas.create') }}" style="color:var(--brand); font-weight:600; text-decoration:none">Create the first one →</a>
        </div>
    @else
        <div style="background:#fff; border:1px solid var(--border); border-radius:12px; overflow:hidden">
            <div style="overflow-x:auto">
                <table style="width:100%; border-collapse:collapse; font-size:.9rem">
                    <thead style="background:var(--page-bg)">
                        <tr style="text-align:left">
                            <th style="padding:.75rem">Title</th>
                            <th style="padding:.75rem">Category</th>
                            <th style="padding:.75rem">Status</th>
                            <th style="padding:.75rem">Featured</th>
                            <th style="padding:.75rem">Views</th>
                            <th style="padding:.75rem; text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ideas as $idea)
                            @php($en = $idea->translations->firstWhere('locale', 'en'))
                            <tr style="border-top:1px solid var(--border)">
                                <td style="padding:.75rem">
                                    <div style="font-weight:600">{{ $en?->title ?? '(untitled)' }}</div>
                                    <div style="font-size:.75rem; color:var(--text-muted)">{{ $idea->slug }}</div>
                                </td>
                                <td style="padding:.75rem">{{ $idea->category?->translation()?->name ?? '—' }}</td>
                                <td style="padding:.75rem">
                                    <form method="POST" action="{{ route('admin.ideas.toggle-publish', $idea) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" style="background:none; border:0; cursor:pointer; padding:0">
                                            @if ($idea->is_published)
                                                <span style="background:#ecfdf5; color:#065f46; padding:.15rem .55rem; border-radius:99px; font-size:.75rem; font-weight:600">Published</span>
                                            @else
                                                <span style="background:#fef3c7; color:#92400e; padding:.15rem .55rem; border-radius:99px; font-size:.75rem; font-weight:600">Draft</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td style="padding:.75rem">
                                    <form method="POST" action="{{ route('admin.ideas.toggle-featured', $idea) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" style="background:none; border:0; cursor:pointer; padding:0; font-size:1.1rem">
                                            @if ($idea->is_featured)
                                                <span style="color:var(--brand)">★</span>
                                            @else
                                                <span style="color:#cbd5e1">☆</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td style="padding:.75rem">{{ number_format($idea->views_count) }}</td>
                                <td style="padding:.75rem; text-align:right; white-space:nowrap">
                                    <a href="{{ route('admin.ideas.show', $idea) }}" style="color:var(--brand); text-decoration:none; font-weight:600; margin-right:.75rem">View</a>
                                    <a href="{{ route('admin.ideas.edit', $idea) }}" style="color:var(--brand); text-decoration:none; font-weight:600; margin-right:.75rem">Edit</a>
                                    <form method="POST" action="{{ route('admin.ideas.destroy', $idea) }}" style="display:inline" onsubmit="return confirm('Delete this idea permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none; border:0; color:#dc2626; font-weight:600; cursor:pointer; padding:0">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top:1.5rem">{{ $ideas->links() }}</div>
    @endif
@endsection
