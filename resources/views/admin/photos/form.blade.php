@extends('admin.layouts.app')
@section('content')
<div style="background:white; padding:2rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); max-width:600px;">
    <h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:1.5rem;">Edit Photo Details</h1>
    <form action="{{ route('admin.photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Title</label>
            <input type="text" name="title" value="{{ old('title', $photo->title)}}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Description</label>
            <textarea name="description" rows="4" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">{{ old('description', $photo->description)}}</textarea>
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Change Image (Optional)</label>
            <img src="{{ asset('storage/'.$photo->file_path) }}" style="width:100px; height:100px; object-fit:cover; border-radius:0.375rem; margin-bottom:0.5rem; display:block;">
            <input type="file" name="file_path" style="width:100%;">
        </div>
        <div style="margin-bottom:1rem;">
            <label><input type="checkbox" name="is_published" value="1" {{ old('is_published', $photo->is_published) ? 'checked' : '' }}> Published</label>
        </div>
        <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 1.5rem; border:none; border-radius:0.375rem; cursor:pointer;">Update Photo Details</button>
    </form>
</div>
@endsection
