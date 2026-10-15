<aside class="admin-sidebar" id="adminSidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        GuhangaAkazi
        <small>Admin Panel</small>
    </a>

    <nav class="sidebar-nav">
        <div class="sidebar-section">Main</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12l9-9 9 9M5 10v10h14V10"/>
            </svg>
            Dashboard
        </a>

        <div class="sidebar-section">Content</div>

        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 3a9 9 0 010 18M12 3v18"/>
            </svg>
            Business Ideas
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3l2.09 6.26L20 10l-5 4.03L16.18 21 12 17.27 7.82 21 9 14.03 4 10l5.91-.74z"/>
            </svg>
            Skills
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="16" rx="2"/>
                <path d="M3 10h18M8 4v4"/>
            </svg>
            Opportunities
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16v12H4z"/><path d="M8 20h8M12 16v4"/>
            </svg>
            Articles
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="9" cy="9" r="2"/><path d="M21 15l-5-5L5 21"/>
            </svg>
            Photos
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <path d="M10 9l5 3-5 3z"/>
            </svg>
            Videos
        </a>

        <div class="sidebar-section">Organize</div>

        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7l9-4 9 4-9 4-9-4z"/><path d="M3 12l9 4 9-4M3 17l9 4 9-4"/>
            </svg>
            Categories
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
            Comments
        </a>

        <div class="sidebar-section">Inbox</div>

        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <path d="M3 7l9 6 9-6"/>
            </svg>
            Contact Messages
        </a>

        <div class="sidebar-section">System</div>

        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
            Website Settings
        </a>
        <a href="#" class="sidebar-link">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 21v-2a6 6 0 016-6h4a6 6 0 016 6v2"/>
            </svg>
            Admin Profile
        </a>
    </nav>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
