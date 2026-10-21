@extends("admin.layouts.app")
@section("content")
<div style="background:white; padding:2rem; border-radius:0.5rem; max-width:600px;">
    <h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:1.5rem;">{{ isset($category) ? "Edit Category" : "New Category" }}</h1>
    <form action="{{ isset($category) ? route("admin.categories.update", $category) : route("admin.categories.store") }}" method="POST">
        @csrf @if(isset($category)) @method("PUT") @endif
        <div style="margin-bottom:1rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Category Name</label><input type="text" name="title" value="{{ old("title", $category->name ?? "") }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;"></div>
        <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 1.5rem; border:none; border-radius:4px; cursor:pointer;">Save</button>
        <a href="{{ route("admin.categories.index") }}" style="padding:0.75rem 1.5rem; border:1px solid #ccc; border-radius:4px; text-decoration:none; color:#374151;">Cancel</a>
    </form>
</div>
@endsection