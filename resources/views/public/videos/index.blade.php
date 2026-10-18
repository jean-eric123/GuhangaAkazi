@extends("public.layouts.app")
@section("content")
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem;">Videos</h1>
        <p style="color: #6b7280; font-size: 1.1rem;">Watch videos about ideas, skills and opportunities.</p>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($videos->isEmpty())
            <div class="text-center" style="padding: 4rem 0;"><h2>No videos available yet.</h2></div>
        @else
            <div class="grid-cards">
                @foreach($videos as $video)
                    <div class="card">
                        @if($video->video_url || $video->file_path)
                            <video controls preload="none"><source src="{{ $video->video_url ?? asset("storage/" . $video->file_path) }}" type="video/mp4"></video>
                        @else
                            <div style="height:200px; background:#000; display:flex; align-items:center; justify-content:center; color:#fff;">No Video Available</div>
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">{{ $video->title ?? "Untitled Video" }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 3rem; display: flex; justify-content: center;">{{ $videos->links() }}</div>
        @endif
    </div>
</div>
@endsection