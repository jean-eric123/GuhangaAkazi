@if($q)
    <div style="font-weight: 600; margin-bottom: 1rem; font-size: 1.1rem; color: #262626;">Results for "{{ $q }}"</div>
    
    @php $hasResults = false; @endphp

    @foreach($ideas as $item)
        @php 
            $hasResults = true; 
            $img = $item->cover_image ? (str_starts_with($item->cover_image, 'http') ? $item->cover_image : asset('storage/' . $item->cover_image)) : null;
        @endphp
        <a href="{{ route('public.ideas.show', $item->slug) }}" style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #efefef; text-decoration: none; color: #262626;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #e5e7eb; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                @if($img)
                    <img src="{{ $img }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'">
                @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8e8e8e" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>
                @endif
            </div>
            <div>
                <div style="font-weight: 600; font-size: 0.95rem;">{{ $item->title ?? 'Untitled Idea' }}</div>
                <div style="color: #8e8e8e; font-size: 0.85rem;">Business Idea</div>
            </div>
        </a>
    @endforeach

    @foreach($skills as $item)
        @php 
            $hasResults = true; 
            $img = $item->cover_image ? (str_starts_with($item->cover_image, 'http') ? $item->cover_image : asset('storage/' . $item->cover_image)) : null;
        @endphp
        <a href="{{ route('public.skills.show', $item->slug) }}" style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #efefef; text-decoration: none; color: #262626;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #e5e7eb; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                @if($img)
                    <img src="{{ $img }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'">
                @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8e8e8e" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>
                @endif
            </div>
            <div>
                <div style="font-weight: 600; font-size: 0.95rem;">{{ $item->title ?? 'Untitled Skill' }}</div>
                <div style="color: #8e8e8e; font-size: 0.85rem;">Skill</div>
            </div>
        </a>
    @endforeach

    @foreach($opportunities as $item)
        @php 
            $hasResults = true; 
            $img = $item->cover_image ? (str_starts_with($item->cover_image, 'http') ? $item->cover_image : asset('storage/' . $item->cover_image)) : null;
        @endphp
        <a href="{{ route('public.opportunities.show', $item->slug) }}" style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #efefef; text-decoration: none; color: #262626;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #e5e7eb; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                @if($img)
                    <img src="{{ $img }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'">
                @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8e8e8e" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>
                @endif
            </div>
            <div>
                <div style="font-weight: 600; font-size: 0.95rem;">{{ $item->title ?? 'Untitled Opportunity' }}</div>
                <div style="color: #8e8e8e; font-size: 0.85rem;">Opportunity</div>
            </div>
        </a>
    @endforeach

    @foreach($videos as $item)
        @php $hasResults = true; @endphp
        <a href="#" style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #efefef; text-decoration: none; color: #262626;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #e5e7eb; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8e8e8e" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
            </div>
            <div>
                <div style="font-weight: 600; font-size: 0.95rem;">{{ $item->title ?? 'Untitled Video' }}</div>
                <div style="color: #8e8e8e; font-size: 0.85rem;">Video</div>
            </div>
        </a>
    @endforeach

    @if(!$hasResults)
        <div style="text-align: center; padding: 3rem 0; color: #8e8e8e;">
            <div style="font-size: 1.1rem; font-weight: 600; color: #262626; margin-bottom: 0.25rem;">No results found</div>
            <div>Try searching for something else.</div>
        </div>
    @endif
@else
    <div style="text-align: center; padding: 3rem 0; color: #8e8e8e;">
        <div style="font-size: 1.1rem; font-weight: 600; color: #262626; margin-bottom: 0.25rem;">Search GuhangaAkazi</div>
        <div>Type to find ideas, skills, and opportunities.</div>
    </div>
@endif