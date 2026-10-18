@if ($paginator->hasPages())
    <nav style="display:flex; justify-content:center; gap:0.5rem; margin-top:2rem; align-items:center;">
        @if ($paginator->onFirstPage())
            <span style="padding:0.5rem 1rem; background:#e5e7eb; color:#9ca3af; border-radius:0.375rem; font-size:0.85rem;">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding:0.5rem 1rem; background:#0B6B4F; color:white; text-decoration:none; border-radius:0.375rem; font-size:0.85rem;">Previous</a>
        @endif

        <span style="padding:0.5rem 1rem; background:white; border:1px solid #e5e7eb; border-radius:0.375rem; font-size:0.85rem; color:#111827;">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding:0.5rem 1rem; background:#0B6B4F; color:white; text-decoration:none; border-radius:0.375rem; font-size:0.85rem;">Next</a>
        @else
            <span style="padding:0.5rem 1rem; background:#e5e7eb; color:#9ca3af; border-radius:0.375rem; font-size:0.85rem;">Next</span>
        @endif
    </nav>
@endif