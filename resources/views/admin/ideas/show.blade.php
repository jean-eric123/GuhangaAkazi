@extends('admin.layouts.app')
@section('title', 'View Idea')
@section('page_title', 'View Idea')

@section('content')
    <?php $en = $idea->translations->firstWhere('locale', 'en'); ?>

    <div style="margin-bottom:1rem">
        <a href="{{ route('admin.ideas.index') }}" style="color:var(--text-muted); text-decoration:none;">&larr; Back</a>
    </div>

    <h2 class="page-title">{{ $en?->title ?? $idea->slug }}</h2>

    <div style="display:flex; gap:.5rem; margin-bottom:1rem;">
        <a href="{{ route('admin.ideas.edit', $idea) }}" style="background:var(--brand); color:#fff; padding:.5rem .9rem; border-radius:8px; text-decoration:none;">Edit</a>
        <form method="POST" action="{{ route('admin.ideas.destroy', $idea) }}" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button type="submit" style="background:#dc2626; color:#fff; border:0; padding:.5rem .9rem; border-radius:8px;">Delete</button>
        </form>
    </div>

    <?php if ($idea->cover_image): ?>
        <div style="margin-bottom:1rem;">
            <img src="{{ $idea->cover_image }}" style="max-width:100%; max-height: 400px; border-radius:8px; display:block; object-fit: cover;">
        </div>
    <?php endif; ?>

    <div style="background:#fff; padding:1rem; border-radius:12px; margin-bottom:1rem;">
        <h3>Money Info</h3>
        <p>Capital: {{ $idea->capital ? number_format($idea->capital, 0) . ' ' . $idea->currency : '—' }}</p>
        <p>Profit: {{ $idea->expected_profit ? number_format($idea->expected_profit, 0) . ' ' . $idea->currency : '—' }}</p>
    </div>

    <?php if (isset($photos) && count($photos) > 0): ?>
        <div style="background:#fff; padding:1rem; border-radius:12px; margin-bottom:1rem;">
            <h3>Photos</h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(120px, 1fr)); gap:1rem; margin-top:1rem;">
                <?php foreach ($photos as $photo): ?>
                    <?php $photoUrl = preg_match('#^https?://#i', $photo->file_path) ? $photo->file_path : asset('storage/' . ltrim($photo->file_path, '/')); ?>
                    <div style="width:100%; aspect-ratio: 1 / 1; overflow:hidden; border-radius:8px; background:#f1f5f4; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <img src="<?= e($photoUrl) ?>" style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($videos) && count($videos) > 0): ?>
        <div style="background:#fff; padding:1rem; border-radius:12px;">
            <h3>Videos</h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:1rem; margin-top:1rem;">
                <?php foreach ($videos as $video): ?>
                    <?php $videoUrl = preg_match('#^https?://#i', $video->file_path) ? $video->file_path : asset('storage/' . ltrim($video->file_path, '/')); ?>
                    <div style="border:1px solid var(--border); border-radius:8px; overflow:hidden;">
                        <video controls style="width:100%; height:auto; display:block;">
                            <source src="<?= e($videoUrl) ?>">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    
    
    {{-- Video Player --}}
    @if (!empty($idea->video_url))
        <div style="background:#fff; padding:1rem; border-radius:12px; margin-top:1rem; border:1px solid var(--border);">
            <h3 style="margin:0 0 1rem; font-size:.95rem;">Video</h3>
            <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:8px;">
                @php
                    $url = trim($idea->video_url);
                    
                    // Extract YouTube ID (handles youtu.be and youtube.com/watch?v=)
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
                        $videoUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
                    }
                    // Extract Vimeo ID
                    elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
                        $videoUrl = 'https://player.vimeo.com/video/' . $matches[1];
                    }
                    else {
                        $videoUrl = null;
                    }
                @endphp

                @if ($videoUrl)
                    <iframe style="position:absolute; top:0; left:0; width:100%; height:100%;" 
                            src="{{ $videoUrl }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                @else
                    <video controls style="position:absolute; top:0; left:0; width:100%; height:100%;">
                        <source src="{{ $url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        </div>
    @endif

@endsection