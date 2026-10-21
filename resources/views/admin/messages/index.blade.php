@extends('admin.layouts.app')
@section('content')
<h1 style="font-size:1.5rem; font-weight:bold; margin-bottom:2rem;">Contact Messages</h1>

@if(session("success"))
    <div style="background:#d1fae5; color:#064e3b; padding:1rem; border-radius:4px; margin-bottom:1rem;">{{ session("success") }}</div>
@endif

@if($messages->isEmpty())
    <div style="background:white; padding:2rem; text-align:center; border-radius:8px;">No messages received yet.</div>
@else
    @foreach($messages as $msg)
        <div style="background:white; padding:1rem; border-radius:8px; margin-bottom:1rem; border-left:4px solid #0B6B4F;">
            <p><strong>Name:</strong> {{ $msg->name }}</p>
            <p><strong>Email:</strong> {{ $msg->email }}</p>
            <p><strong>Message:</strong> {{ $msg->message }}</p>
            <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST">@csrf @method('DELETE')<button type="submit" style="color:red; background:none; border:none; cursor:pointer; font-weight:bold; margin-top:10px;">Delete Message</button></form>
        </div>
    @endforeach
    
    <div style="margin-top:1rem;">{{ $messages->links() }}</div>
@endif
@endsection
