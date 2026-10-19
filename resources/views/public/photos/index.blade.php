@extends("public.layouts.app")
@section("content")
<div class="bg-light" style="padding: 3rem 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 0.5rem;">Photos</h1>
        <p style="color: #6b7280; font-size: 1.1rem;">Explore our gallery.</p>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($photos->isEmpty())
            <div class="text-center" style="padding: 4rem 0;"><h2>No photos available yet.</h2></div>
        @else
            <div class="grid-cards">
                @foreach($photos as $photo)
                    <div class="card">
                        @php $img = $photo->file_path; $src = $img ? (str_starts_with($img, "http") ? $img : Storage::disk("r2")->url($img)) : null; @endphp
                        @if($src)
                            <img src="{{ $src }}" class="card-img" loading="lazy">
                        @else
                            <div class="card-img"></div>
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">{{ $photo->title ?? "Untitled Photo" }}</h3>
                            @if($photo->description)
                                <p class="card-text">{{ Str::limit($photo->description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 3rem; display: flex; justify-content: center;">{{ $photos->links() }}</div>
        @endif
    </div>
</div>
@endsection