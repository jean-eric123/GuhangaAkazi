@extends('admin.layouts.app')
@section('title', 'Videos')
@section('page_title', 'Videos')
@section('content')
    <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
        <h2 class="page-title">Videos</h2>
        <a href="{{ route('admin.videos.create') }}" style="background:var(--brand); color:#fff; padding:.5rem 1rem; border-radius:8px; text-decoration:none; font-weight:600;">+ Add Video</a>
    </div>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if($videos->isEmpty())
        <p style="color:var(--text-muted); text-align:center; padding:2rem;">No videos yet.</p>
    @else
        <div style="background:#fff; border-radius:12px; overflow:hidden;">
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background:var(--page-bg);">
                    <tr>
                        <th style="padding:.75rem; text-align:left;">Title</th>
                        <th style="padding:.75rem; text-align:left;">Status</th>
                        <th style="padding:.75rem; text-align:left;">Featured</th>
                        <th style="padding:.75rem; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $v)
                        <tr style="border-top:1px solid var(--border);">
                            <td style="padding:.75rem;">
                                <div style="display:flex; align-items:center; gap:.5rem;">
                                    <div style="width:48px; height:48px; background:#000; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.2rem;">▶</div>
                                    <div>
                                        <div style="font-weight:600;">{{ $v->title }}</div>
                                        <div style="font-size:.75rem; color:var(--text-muted);">{{ basename($v->file_path) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:.75rem;">
                                <form method="POST" action="{{ route('admin.videos.toggle-publish', $v) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="border:0; cursor:pointer; padding:.15rem .55rem; border-radius:99px; font-size:.75rem; font-weight:600; {{ $v->is_published ? 'background:#ecfdf5; color:#065f46;' : 'background:#fef3c7; color:#92400e;' }}">
                                        {{ $v->is_published ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td style="padding:.75rem;">
                                <form method="POST" action="{{ route('admin.videos.toggle-featured', $v) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:none; border:0; cursor:pointer; font-size:1.2rem;">{{ $v->is_featured ? '★' : '☆' }}</button>
                                </form>
                            </td>
                            <td style="padding:.75rem; text-align:right; white-space:nowrap;">
                                <a href="{{ route('admin.videos.show', $v) }}" style="color:var(--brand); text-decoration:none; font-weight:600; margin-right:.75rem;">View</a>
                                <a href="{{ route('admin.videos.edit', $v) }}" style="color:var(--brand); text-decoration:none; font-weight:600; margin-right:.75rem;">Edit</a>
                                <form method="POST" action="{{ route('admin.videos.destroy', $v) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color:#dc2626; background:none; border:0; font-weight:600; cursor:pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">{{ $videos->links() }}</div>
    @endif
@endsection
