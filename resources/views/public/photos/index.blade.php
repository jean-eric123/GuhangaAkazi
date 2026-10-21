@extends("public.layouts.app")
@section("content")
<div class="container" style="padding: 4rem 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 2rem; text-align: center;">Photo Gallery</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @forelse($photos as $photo)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @php $img = $photo->file_path ?? $photo->image_path ?? false; @endphp
            @if($img)
                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::disk('r2')->url($img) }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @else
                <img src="https://placehold.co/600x400/e2e8f0/475569?text=Photo" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $photo->translations->first()?->title ?? 'Photo' }}</h3>
                <div style="margin-top: auto;">@include('public.partials.engagement', ['type' => 'photo', 'item' => $photo])</div>
            </div>
        </div>
        @empty
        <p style="text-align: center; grid-column: 1 / -1; color: #6b7280;">No photos found.</p>
        @endforelse
    </div>
    <div style="margin-top: 2rem; display: flex; justify-content: center;">{{ $photos->links() }}</div>
</div>
@endsection