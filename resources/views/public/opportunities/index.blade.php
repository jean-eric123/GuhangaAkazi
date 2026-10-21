@extends("public.layouts.app")
@section("content")
<div class="container" style="padding: 4rem 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 2rem; text-align: center;">Opportunities</h1>
    <div class="grid-cards">
        @forelse($opportunities as $opportunity)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            @if($opportunity->image_path ?? $opportunity->image ?? false)
            <img src="{{ Storage::disk('r2')->url($opportunity->image_path ?? $opportunity->image) }}" alt="Opportunity" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-bottom: 1px solid #e2e8f0;">
            @endif
            <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a;">{{ $opportunity->translations->first()?->title ?? 'Untitled Opportunity' }}</h3>
                <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 1rem; display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ Str::limit($opportunity->translations->first()?->short_description ?? $opportunity->translations->first()?->description ?? '', 100) }}</p>
                <a href="{{ route('public.opportunities.show', $opportunity->slug) }}" style="margin-top: auto; color: #0B6B4F; font-weight: 700; text-decoration: none; margin-bottom: 1rem;">View Details &rarr;</a>
                @include('public.partials.engagement', ['type' => 'opportunity', 'item' => $opportunity])
            </div>
        </div>
        @empty
        <p style="text-align: center; grid-column: 1 / -1; color: #6b7280;">No opportunities found.</p>
        @endforelse
    </div>
    <div style="margin-top: 2rem; display: flex; justify-content: center;">{{ $opportunities->links() }}</div>
</div>
@endsection