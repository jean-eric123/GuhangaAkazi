@extends("admin.layouts.app")
@section("content")
<div style="background:white; padding:2rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); max-width:600px;">
    <h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:1.5rem;">Upload New Photo</h1>
    <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Photo Title</label>
            <input type="text" name="title" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Description</label>
            <textarea name="description" rows="3" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;"></textarea>
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Select Image</label>
            
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Or Paste Link (Cloudflare/YouTube)</label>
            <input type="text" name="file_url" placeholder="https://..." style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;">
        </div>
<input type="file" name="image" accept="image/*" style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:0.375rem;">
        </div>
        <div style="margin-bottom:1.5rem;">
            <label><input type="checkbox" name="is_published" value="1" checked> Publish this photo</label>
        </div>
        <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 1.5rem; border:none; border-radius:0.375rem; cursor:pointer; font-weight:600;">Upload to Cloudflare</button>
    </form>
</div>
@endsection