@extends("admin.layouts.app")
@section("content")
@php
    $isEdit = isset($idea);
    $title  = $isEdit ? "Edit Business Idea" : "New Business Idea";
    $action = $isEdit ? route("admin.ideas.update", $idea) : route("admin.ideas.store");
@endphp

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:.5rem">
    <h2 style="font-size:1.5rem; font-weight:700; margin:0;">{{ $title }}</h2>
    <a href="{{ route("admin.ideas.index") }}" style="color:#6b7280; text-decoration:none; font-weight:500;">&larr; Back to list</a>
</div>

@if($errors->any())
    <div style="background:#fee2e2; color:#b91c1c; padding:1rem; border-radius:0.375rem; margin-bottom:1rem;">
        <ul style="margin:0; padding-left:1.5rem;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method("PUT") @endif

    <!-- Basic Info -->
    <div style="background:white; padding:1.5rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:1.5rem;">
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Title *</label>
            <input type="text" name="en_title" value="{{ old("en_title", $isEdit ? $en->title : "") }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Category</label>
            <select name="category_id" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
                <option value="">— none —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old("category_id", $isEdit ? $idea->category_id : "") == $cat->id ? "selected" : "" }}>
                        {{ $cat->translation()?->name ?? $cat->slug }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div>
                <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Starting Capital</label>
                <input type="number" name="capital" value="{{ old("capital", $isEdit ? $idea->capital : "") }}" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
            </div>
            <div>
                <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Expected Profit</label>
                <input type="number" name="expected_profit" value="{{ old("expected_profit", $isEdit ? $idea->expected_profit : "") }}" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">
            </div>
        </div>
    </div>

    <!-- Descriptions -->
    <div style="background:white; padding:1.5rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:1.5rem;">
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Short Description</label>
            <textarea name="en_short_description" rows="2" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">{{ old("en_short_description", $isEdit ? $en->short_description : "") }}</textarea>
        </div>
        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Full Description</label>
            <textarea name="en_full_description" rows="5" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:0.375rem;">{{ old("en_full_description", $isEdit ? $en->full_description : "") }}</textarea>
        </div>
    </div>

    <!-- Images -->
    <div style="background:white; padding:1.5rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:1.5rem;">
        <h3 style="font-weight:bold; margin-bottom:1rem;">Cover Image</h3>
        <input type="hidden" name="cover_image" id="cover_image_input" value="{{ old("cover_image", $isEdit ? $idea->cover_image : "") }}">
        
        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
            <input type="file" id="cover_upload" accept="image/*" style="display:none;">
            <button type="button" onclick="document.getElementById('cover_upload').click()" style="background:#0B6B4F; color:white; padding:0.5rem 1rem; border:none; border-radius:0.375rem; cursor:pointer;">📷 Choose Photo</button>
            <span id="cover_status" style="color:#059669; font-weight:600; display:{{ ($isEdit && $idea->cover_image) ? 'inline' : 'none' }};">✅ Uploaded</span>
        </div>

        @php
            $img = old("cover_image", $isEdit ? $idea->cover_image : null);
            $imgUrl = $img ? (str_starts_with($img, "http") ? $img : Storage::disk("r2")->url($img)) : null;
        @endphp
        <img id="cover_preview" src="{{ $imgUrl }}" style="max-width:200px; border-radius:0.375rem; display:{{ $imgUrl ? 'block' : 'none' }};">
    </div>

    <!-- Publishing -->
    <div style="background:white; padding:1.5rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:1.5rem; display:flex; gap:2rem;">
        <label style="display:flex; align-items:center; gap:0.5rem; font-weight:600;">
            <input type="checkbox" name="is_featured" value="1" {{ old("is_featured", $isEdit ? $idea->is_featured : false) ? "checked" : "" }}> Feature on Home Page
        </label>
        <label style="display:flex; align-items:center; gap:0.5rem; font-weight:600;">
            <input type="checkbox" name="is_published" value="1" {{ old("is_published", $isEdit ? $idea->is_published : true) ? "checked" : "" }}> Publish immediately
        </label>
    </div>

    
        <div style="margin-bottom:1.5rem; background:#f0fdf4; padding:1rem; border-radius:8px; border:1px solid #dcfce7;">
            <label style="display:block; font-weight:bold; margin-bottom:0.5rem; color:#064e3b;">Or Paste Image URL (Cloudflare/YouTube)</label>
            <input type="url" name="cover_image_url" placeholder="https://pub-xxxx.r2.dev/..." style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;">
        </div>
    <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 2rem; border:none; border-radius:0.375rem; font-weight:600; cursor:pointer; font-size:1rem;">Save Idea</button>
</form>

<script>
document.getElementById("cover_upload").addEventListener("change", async function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append("file", file);
    formData.append("_token", "{{ csrf_token() }}");

    try {
        const res = await fetch("{{ route('admin.media.cover') }}", { method: "POST", body: formData });
        const data = await res.json();
        
        if (data.url) {
            document.getElementById("cover_image_input").value = data.path;
            const preview = document.getElementById("cover_preview");
            preview.src = data.url;
            preview.style.display = "block";
            document.getElementById("cover_status").style.display = "inline";
        }
    } catch (err) {
        alert("Upload failed. Please try a smaller image.");
    }
});
</script>
@endsection