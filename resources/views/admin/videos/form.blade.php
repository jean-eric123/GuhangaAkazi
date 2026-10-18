@extends('admin.layouts.app')
@php
    $isEdit = $video !== null;
    $title = $isEdit ? 'Edit Video' : 'Upload Video';
    $action = $isEdit ? route('admin.videos.update', $video) : route('admin.videos.store');
@endphp
@section('title', $title)
@section('page_title', $title)
@section('content')
    <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
        <h2 class="page-title" style="margin:0;">{{ $title }}</h2>
        <a href="{{ route('admin.videos.index') }}" style="color:var(--text-muted); text-decoration:none;">← Back</a>
    </div>
    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0; padding-left:1.25rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" style="background:#fff; padding:1.5rem; border-radius:12px;">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:600; margin-bottom:.3rem;">Title</label>
            <input type="text" name="title" value="{{ old('title', $video?->title) }}" required style="width:100%; padding:.5rem .8rem; border:1px solid var(--border); border-radius:8px;">
        </div>

        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:600; margin-bottom:.3rem;">Video File {{ $isEdit ? '(leave empty to keep current)' : '' }}</label>
            <input type="file" name="file" accept="video/*" {{ $isEdit ? '' : 'required' }} style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px; background:#fff;">
        </div>

        <div style="margin-bottom:1rem; display:flex; flex-direction:column; gap:.5rem;">
            <label style="display:flex; align-items:center; gap:.5rem; font-size:.9rem;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $video?->is_published ?? true) ? 'checked' : '' }}>
                Publish immediately
            </label>
            <label style="display:flex; align-items:center; gap:.5rem; font-size:.9rem;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $video?->is_featured) ? 'checked' : '' }}>
                Feature on Home Page
            </label>
        </div>

        <div style="display:flex; gap:.5rem; flex-wrap:wrap; padding-top:1rem; border-top:1px solid var(--border);">
            <button type="submit" style="background:var(--brand); color:#fff; padding:.7rem 1.5rem; border-radius:8px; border:0; font-weight:600; cursor:pointer;">{{ $isEdit ? 'Update Video' : 'Upload Video' }}</button>
            <a href="{{ route('admin.videos.index') }}" style="padding:.7rem 1.5rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text); font-weight:600;">Cancel</a>
        </div>
    </form>
@endsection
