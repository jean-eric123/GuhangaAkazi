@extends("admin.layouts.app")
@section("content")
<div style="background:white; padding:2rem; border-radius:0.5rem; max-width:600px;">
    <h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:1.5rem;">{{ isset($post) ? "Edit Article" : "New Article" }}</h1>
    <form action="{{ isset($post) ? route("admin.posts.update", $post) : route("admin.posts.store") }}" method="POST" enctype="multipart/form-data">
        @csrf @if(isset($post)) @method("PUT") @endif
        <div style="margin-bottom:1rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Title</label><input type="text" name="title" value="{{ old("title", $post->title ?? "") }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;"></div>
        <div style="margin-bottom:1rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Description</label><textarea name="description" rows="5" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;">{{ old("description", $post->description ?? "") }}</textarea></div>
        <div style="margin-bottom:1rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Cover Image</label>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Or Paste Link (Cloudflare/YouTube)</label>
            <input type="text" name="cover_image_url" placeholder="https://..." style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;">
        </div>
<input type="file" name="cover_image" style="width:100%;"></div>
        <div style="margin-bottom:1rem;"><label><input type="checkbox" name="is_published" value="1" {{ old("is_published", $post->is_published ?? true) ? "checked" : "" }}> Publish</label></div>
        <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 1.5rem; border:none; border-radius:4px;">Save</button>
    </form>
</div>
@endsection