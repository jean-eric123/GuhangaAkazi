@extends('admin.layouts.app')
@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <h1 style="font-size:1.5rem; font-weight:bold;">Skills</h1>
    <a href="{{ route('admin.skills.create') }}" style="background:#0B6B4F; color:white; padding:0.5rem 1rem; border-radius:0.375rem; text-decoration:none;">+ Add Skill</a>
</div>
@if(session('success'))
    <div style="background:#d1fae5; color:#064e3b; padding:1rem; border-radius:0.375rem; margin-bottom:1rem;">{{ session('success') }}</div>
@endif
<div style="background:white; padding:1rem; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
    @if($skills->isEmpty())
        <p style="text-align:center; padding:2rem; color:#6b7280;">No skills found. Click "+ Add Skill" to create one.</p>
    @else
        @foreach($skills as $skill)
            <div style="padding:1rem; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    @if($skill->cover_image)
                        <img src="{{ asset('storage/' . $skill->cover_image) }}" style="width:40px; height:40px; object-fit:cover; border-radius:4px; margin-right:10px; vertical-align:middle;">
                    @endif
                    <span style="font-weight:bold;">{{ $skill->title ?? 'Untitled' }}</span>
                </div>
                <div>
                    <a href="{{ route('admin.skills.edit', $skill) }}" style="color:#0B6B4F; margin-right:1rem; text-decoration:none;">Edit</a>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
        <div style="margin-top:1rem;">{{ $skills->links() }}</div>
    @endif
</div>
@endsection
