@extends('admin.layouts.app')

@section('content')
<div class="container" style="padding: 2rem; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Manage Comments</h1>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 1rem; font-weight: 700; color: #475569;">User Name</th>
                    <th style="padding: 1rem; font-weight: 700; color: #475569;">Comment</th>
                    <th style="padding: 1rem; font-weight: 700; color: #475569;">Date</th>
                    <th style="padding: 1rem; font-weight: 700; color: #475569; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem; color: #0f172a; font-weight: 600;">
                        {{ $comment->name ?? 'Guest' }}
                    </td>
                    <td style="padding: 1rem; color: #334155; max-width: 400px;">
                        {{ $comment->comment }}
                    </td>
                    <td style="padding: 1rem; color: #64748b; font-size: 0.9rem;">
                        {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y h:i A') }}
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #64748b;">
                        No comments found on the website yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection