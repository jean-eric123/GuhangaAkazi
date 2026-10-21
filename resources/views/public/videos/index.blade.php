@extends("public.layouts.app")
@section("content")
<div class="container" style="padding: 4rem 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 2rem; text-align: center;">Latest Videos</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
        @forelse($videos as $video)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            <div style="position: relative; aspect-ratio: 16/9; background: #000;">
                @php $vFile = $video->file_path ?? false; @endphp
                @if($video->video_url)
                <iframe src="{{ $video->video_url }}" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                @elseif($vFile)
                <video controls style="width: 100%; height: 100%; object-fit: cover;">
                    <source src="{{ Str::startsWith($vFile, 'http') ? $vFile : Storage::disk('r2')->url($vFile) }}">
                </video>
                @else
                <img src="https://placehold.co/600x400/e2e8f0/475569?text=Video" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $video->translations->first()?->title ?? 'Video' }}</h3>
                <div style="margin-top: auto;">@include('public.partials.engagement', ['type' => 'video', 'item' => $video])</div>
            </div>
        </div>
        @empty
        <p style="text-align: center; grid-column: 1 / -1; color: #6b7280;">No videos found.</p>
        @endforelse
    </div>
    <div style="margin-top: 2rem; display: flex; justify-content: center;">{{ $videos->links() }}</div>
</div>
@endsection