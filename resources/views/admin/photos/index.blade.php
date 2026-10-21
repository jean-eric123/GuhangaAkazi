@extends('admin.layouts.app')
@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <h1 style="font-size:1.5rem; font-weight:bold;">Photos Gallery</h1>
    <a href="{{ route("admin.photos.create") }}" style="background:#0B6B4F; color:white; padding:0.5rem 1rem; border-radius:0.375rem; text-decoration:none; font-weight:600;">+ Upload Photo</a>
</div>
@if(session("success"))
    <div style="background:#d1fae5; color:#064e3b; padding:1rem; border-radius:0.375rem; margin-bottom:1rem;">{{ session("success") }}</div>
@endif
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:1rem;">
    @foreach($photos as $photo)
        <div style="background:white; border-radius:0.5rem; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.1); display:flex; flex-direction:column;">
            @php
                $img = $photo->file_path;
                $src = $img ? (str_starts_with($img, "http") ? $img : Storage::disk("r2")->url($img)) : "https://via.placeholder.com/150?text=No+Img";
            @endphp
            <img src="{{ $src }}" style="width:100%; height:120px; object-fit:cover;" onerror="this.src='https://via.placeholder.com/150?text=Error'">
            <div style="padding:0.75rem; display:flex; flex-direction:column; flex-grow:1;">
                <div style="font-weight:bold; font-size:0.85rem; margin-bottom:0.5rem; line-height:1.2;">{{ Str::limit($photo->title ?? "Untitled", 20) }}</div>
                <div style="margin-top:auto; display:flex; justify-content:space-between; align-items:center;">
                    <a href="{{ route("admin.photos.edit", $photo) }}" style="color:#0B6B4F; text-decoration:none; font-size:0.75rem; font-weight:600;">Edit</a>
                    <form action="{{ route("admin.photos.destroy", $photo) }}" method="POST">@csrf @method("DELETE")<button type="submit" style="color:red; background:none; border:none; cursor:pointer; font-size:0.75rem; font-weight:600;">Delete</button></form>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div style="margin-top:2rem;">{{ $photos->links() }}</div>
@endsection
