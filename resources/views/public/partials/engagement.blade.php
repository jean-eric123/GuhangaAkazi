@php
    $class = get_class($item);
    $viewCount = DB::table('page_views')->where('viewable_id', $item->id)->where('viewable_type', $class)->count();
    $likeCount = DB::table('likes')->where('likeable_id', $item->id)->where('likeable_type', $class)->count();
    $commentsList = DB::table('comments')->where('commentable_id', $item->id)->orderBy('created_at', 'desc')->get();
@endphp

<div id="engagement-{{ $item->id }}" style="margin-top: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
    
    <!-- Views & Likes -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.85rem; color: #6b7280; font-weight: 500;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            {{ number_format($viewCount) }} Views
        </span>

        <form action="{{ route('public.like', [$type, $item->id]) }}" method="POST" onsubmit="submitLike(event, {{ $item->id }})" style="margin: 0;">
            @csrf
            <button type="submit" style="background: none; border: none; padding: 0; display: flex; align-items: center; gap: 0.25rem; color: #6b7280; font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.514"></path></svg>
                <span id="like-count-{{ $item->id }}">{{ $likeCount }}</span> Likes
            </button>
        </form>
    </div>

    <!-- Comment Form -->
    <form action="{{ route('public.comment', [$type, $item->id]) }}" method="POST" onsubmit="submitComment(event, {{ $item->id }})" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
        @csrf
        <input type="text" id="comment-input-{{ $item->id }}" name="comment" placeholder="Add a comment..." required style="flex-grow: 1; border: none; border-bottom: 1px solid #d1d5db; padding: 0.5rem 0; outline: none; background: transparent; font-size: 0.9rem;">
        <button type="submit" style="background: #0B6B4F; color: white; border: none; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">Post</button>
    </form>

    <!-- Display Comments -->
    <div id="comments-list-{{ $item->id }}" style="display: flex; flex-direction: column; gap: 0.75rem;">
        @forelse($commentsList as $comment)
            @php
                // Safely fetch the text regardless of the column name (comment, body, content, or message)
                $text = $comment->comment ?? $comment->body ?? $comment->content ?? $comment->message ?? '';
            @endphp
            <div style="display: flex; gap: 0.75rem;">
                <div style="width: 32px; height: 32px; background: #e5e7eb; color: #374151; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">
                    {{ strtoupper(substr($comment->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: #111827;">{{ $comment->name ?? 'User' }}</div>
                    <div style="font-size: 0.9rem; color: #374151; line-height: 1.4;">{{ $text }}</div>
                </div>
            </div>
        @empty
            <p id="no-comments-{{ $item->id }}" style="font-size: 0.85rem; color: #6b7280;">No comments yet.</p>
        @endforelse
    </div>
</div>

<script>
    function submitLike(event, id) {
        event.preventDefault(); 
        const form = event.target;
        const countSpan = document.getElementById('like-count-' + id);
        
        fetch(form.action, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) { 
                countSpan.innerText = data.count; 
            } else {
                alert('Like error: ' + (data.error || 'Unknown error'));
            }
        });
    }

    function submitComment(event, id) {
        event.preventDefault(); 
        const form = event.target;
        const input = document.getElementById('comment-input-' + id);
        const commentText = input.value;
        const list = document.getElementById('comments-list-' + id);
        const noComments = document.getElementById('no-comments-' + id);

        fetch(form.action, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify({ 
                comment: commentText,
                name: 'Guest User', 
                email: 'guest@example.com'
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                if(noComments) noComments.style.display = 'none';
                const newComment = document.createElement('div');
                newComment.style.cssText = 'display: flex; gap: 0.75rem;';
                newComment.innerHTML = `
                    <div style="width: 32px; height: 32px; background: #e5e7eb; color: #374151; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">G</div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: #111827;">Guest User</div>
                        <div style="font-size: 0.9rem; color: #374151; line-height: 1.4;">${commentText}</div>
                    </div>
                `;
                list.prepend(newComment);
                input.value = ''; 
            } else {
                alert('Error saving comment: ' + (data.error || 'Unknown database error.'));
            }
        });
    }
</script>