@extends("admin.layouts.app")
@section("content")
@php
    $isEdit = isset($video);
    $title = $isEdit ? "Edit Video" : "Upload Video";
@endphp
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <h1 style="font-size:1.5rem; font-weight:bold;">{{ $title }}</h1>
    <a href="{{ route("admin.videos.index") }}" style="color:#6b7280; text-decoration:none; font-weight:500;">&larr; Back to Videos</a>
</div>

@if($errors->any())
    <div style="background:#fee2e2; color:#b91c1c; padding:1rem; border-radius:0.375rem; margin-bottom:1rem;">
        <ul style="margin:0; padding-left:1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="background:white; padding:2rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); max-width:600px;">
    <form action="{{ $isEdit ? route("admin.videos.update", $video) : route("admin.videos.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method("PUT")
        @endif

        <div style="margin-bottom:1.5rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Video Title</label>
            <input type="text" name="title" value="{{ old("title", $isEdit ? $video->title : "") }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
        </div>

        <div style="margin-bottom:1.5rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Video File (MP4)</label>
            @if($isEdit && $video->file_path)
                <div style="margin-bottom:0.5rem; color:#059669; font-size:0.85rem; font-weight:600;">Current file: {{ basename($video->file_path) }}</div>
            @endif
            <input type="file" name="file" accept="video/mp4,video/quicktime" {{ $isEdit ? "" : "required" }} style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:0.375rem;">
            <p style="font-size:0.75rem; color:#6b7280; margin-top:0.25rem;">Max 100MB. (Note: Codespaces has a 10MB upload limit. Large videos will work after real hosting).</p>
        </div>

        <div style="margin-bottom:1.5rem; display:flex; gap:1.5rem;">
            <label style="display:flex; align-items:center; gap:0.5rem; font-weight:500;">
                <input type="checkbox" name="is_published" value="1" {{ old("is_published", $isEdit ? $video->is_published : true) ? "checked" : "" }}>
                Publish immediately
            </label>
            <label style="display:flex; align-items:center; gap:0.5rem; font-weight:500;">
                <input type="checkbox" name="is_featured" value="1" {{ old("is_featured", $isEdit ? $video->is_featured : false) ? "checked" : "" }}>
                Feature on Home Page
            </label>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 2rem; border:none; border-radius:0.375rem; font-weight:600; cursor:pointer;">{{ $isEdit ? "Update Video" : "Upload Video" }}</button>
            <a href="{{ route("admin.videos.index") }}" style="padding:0.75rem 1.5rem; border:1px solid #ccc; border-radius:0.375rem; text-decoration:none; color:#374151; font-weight:600;">Cancel</a>
        </div>
    </form>
</div>
@endsection