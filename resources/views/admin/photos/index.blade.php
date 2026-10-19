@extends("admin.layouts.app")
@section("content")
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <h1 style="font-size:1.5rem; font-weight:bold;">Photos Gallery</h1>
    <a href="{{ route("admin.photos.create") }}" style="background:#0B6B4F; color:white; padding:0.5rem 1rem; border-radius:0.375rem; text-decoration:none; font-weight:600;">+ Upload Photo</a>
</div>
@if(session("success"))
    <div style="background:#d1fae5; color:#064e3b; padding:1rem; border-radius:0.375rem; margin-bottom:1rem;">{{ session("success") }}</div>
@endif
<div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:1rem;">
    @forelse($photos as $photo)
        <div style="background:white; padding:0.75rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
            @php
                $img = $photo->file_path;
                $src = $img ? (str_starts_with($img, "http") ? $img : Storage::disk("r2")->url($img)) : "https://via.placeholder.com/150?text=No+Img";
            @endphp
            <img src="{{ $src }}" style="width:100%; height:120px; object-fit:cover; border-radius:0.375rem; margin-bottom:0.75rem;" onerror="this.src='https://via.placeholder.com/150?text=Err'">
            <div style="font-weight:bold; margin-bottom:0.5rem; font-size:0.85rem; line-height: 1.2;">{{ Str::limit($photo->title ?? "Untitled", 25) }}</div>
            <div style="margin-top:auto;">
                <a href="{{ route("admin.photos.edit", $photo) }}" style="color:#0B6B4F; text-decoration:none; font-size:0.75rem; margin-right:10px;">Edit</a>
                <form action="{{ route("admin.photos.destroy", $photo) }}" method="POST" style="display:inline;">
                    @csrf @method("DELETE")
                    <button type="submit" style="color:red; background:none; border:none; cursor:pointer; font-size:0.75rem;">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div style="padding:2rem; text-align:center; color:#6b7280; background:white; border-radius:0.5rem; grid-column: 1 / -1;">
            No photos uploaded yet.
        </div>
    @endforelse
</div>
<div style="margin-top:2rem;">{{ $photos->links() }}</div>
@endsection