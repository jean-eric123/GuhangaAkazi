@extends("admin.layouts.app")
@section("content")
<div style="background:white; padding:2rem; border-radius:0.5rem; max-width:600px;">
    <h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:1.5rem;">Admin Profile</h1>
    @if(session("success"))<div style="background:#d1fae5; padding:1rem; margin-bottom:1rem; border-radius:0.375rem;">{{ session("success") }}</div>@endif
    <form action="{{ route("admin.profile.update") }}" method="POST">
        @csrf @method("PUT")
        <div style="margin-bottom:1rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Name</label><input type="text" name="name" value="{{ $admin->name }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;"></div>
        <div style="margin-bottom:1rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">Email</label><input type="email" name="email" value="{{ $admin->email }}" required style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;"></div>
        <div style="margin-bottom:1.5rem;"><label style="display:block; font-weight:bold; margin-bottom:0.5rem;">New Password (leave blank to keep current)</label><input type="password" name="password" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:4px;"></div>
        <button type="submit" style="background:#0B6B4F; color:white; padding:0.75rem 1.5rem; border:none; border-radius:4px; cursor:pointer;">Update Profile</button>
    </form>
</div>
@endsection