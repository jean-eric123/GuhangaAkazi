@extends("admin.layouts.app")
@section("content")
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <h1 style="font-size:1.5rem; font-weight:bold;">Categories</h1>
    <a href="{{ route("admin.categories.create") }}" style="background:#0B6B4F; color:white; padding:0.5rem 1rem; border-radius:0.375rem; text-decoration:none;">+ Add Category</a>
</div>
@if(session("success"))<div style="background:#d1fae5; padding:1rem; margin-bottom:1rem; border-radius:0.375rem;">{{ session("success") }}</div>@endif
<div style="background:white; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); padding:1rem;">
    <table style="width:100%; border-collapse:collapse;">
        <thead><tr style="border-bottom:1px solid #e5e7eb; text-align:left;"><th style="padding:1rem;">Name</th><th style="padding:1rem; text-align:right;">Actions</th></tr></thead>
        <tbody>
            @forelse($categories as $cat)
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:1rem; font-weight:600;">{{ $cat->name ?? $cat->slug }}</td>
                    <td style="padding:1rem; text-align:right;">
                        <a href="{{ route("admin.categories.edit", $cat) }}" style="color:#0B6B4F; margin-right:1rem; text-decoration:none;">Edit</a>
                        <form action="{{ route("admin.categories.destroy", $cat) }}" method="POST" style="display:inline;">@csrf @method("DELETE")<button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" style="padding:2rem; text-align:center; color:#6b7280;">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection