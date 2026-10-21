@extends('admin.layouts.app')
@section('content')
<div style="background:white; padding:2rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
    <h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:1.5rem;">{{ isset($skill) ? 'Edit Skill' : 'New Skill' }}</h1>
    <form action="{{ isset($skill) ? route('admin.skills.update', $skill) : route('admin.skills.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($skill)) @method('PUT') @endif
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Title</label>
            <input type="text" name="title" value="{{ old('title', $skill->title ?? '') }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Description</label>
            <textarea name="description" rows="4" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">{{ old('description', $skill->description ?? '') }}</textarea>
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Cover Image</label>
            
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Or Paste Link (Cloudflare/YouTube)</label>
            <input type="text" name="cover_image_url" placeholder="https://..." style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;">
        </div>
<input type="file" name="cover_image" style="width:100%;">
        </div>
        <div style="margin-bottom:1rem;">
            <label><input type="checkbox" name="is_published" value="1" {{ old('is_published', $skill->is_published ?? true) ? 'checked' : '' }}> Publish</label>
        </div>
        <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 1.5rem; border:none; border-radius:0.375rem; cursor:pointer;">Save</button>
    </form>
</div>
@endsection
