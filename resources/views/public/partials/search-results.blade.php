@if(isset($q) && $q != '')
    @if($ideas->count() == 0 && $posts->count() == 0 && $skills->count() == 0 && $opportunities->count() == 0 && $photos->count() == 0 && $videos->count() == 0)
        <div style="padding: 1rem; text-align: center; color: #6b7280;">No results found for "{{ $q }}"</div>
    @else
        @foreach($ideas as $idea)
            <a href="{{ route('public.ideas.show', $idea->slug) }}" class="search-result-item">
                <span style="font-size: 0.75rem; color: #0B6B4F; font-weight: 700; text-transform: uppercase;">Idea</span><br>
                <strong>{{ $idea->translations->first()?->title ?? 'Idea' }}</strong>
            </a>
        @endforeach
        @foreach($skills as $skill)
            <a href="{{ route('public.skills.show', $skill->slug) }}" class="search-result-item">
                <span style="font-size: 0.75rem; color: #0B6B4F; font-weight: 700; text-transform: uppercase;">Skill</span><br>
                <strong>{{ $skill->translations->first()?->title ?? 'Skill' }}</strong>
            </a>
        @endforeach
        @foreach($opportunities as $opportunity)
            <a href="{{ route('public.opportunities.show', $opportunity->slug) }}" class="search-result-item">
                <span style="font-size: 0.75rem; color: #0B6B4F; font-weight: 700; text-transform: uppercase;">Opportunity</span><br>
                <strong>{{ $opportunity->translations->first()?->title ?? 'Opportunity' }}</strong>
            </a>
        @endforeach
        @foreach($posts as $post)
            <a href="{{ route('public.articles.show', $post->slug) }}" class="search-result-item">
                <span style="font-size: 0.75rem; color: #0B6B4F; font-weight: 700; text-transform: uppercase;">Article</span><br>
                <strong>{{ $post->translations->first()?->title ?? 'Article' }}</strong>
            </a>
        @endforeach
        @foreach($photos as $photo)
            <a href="{{ route('public.photos') }}" class="search-result-item">
                <span style="font-size: 0.75rem; color: #0B6B4F; font-weight: 700; text-transform: uppercase;">Photo</span><br>
                <strong>{{ $photo->translations->first()?->title ?? 'Photo' }}</strong>
            </a>
        @endforeach
        @foreach($videos as $video)
            <a href="{{ route('public.videos') }}" class="search-result-item">
                <span style="font-size: 0.75rem; color: #0B6B4F; font-weight: 700; text-transform: uppercase;">Video</span><br>
                <strong>{{ $video->translations->first()?->title ?? 'Video' }}</strong>
            </a>
        @endforeach
    @endif
@endif