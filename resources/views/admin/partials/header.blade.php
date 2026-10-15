<header class="admin-header">
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M3 6h18M3 12h18M3 18h18"/>
        </svg>
    </button>

    <h1 class="header-title">@yield('page_title', 'Admin')</h1>

    <div class="header-user">
        <strong>{{ auth('admin')->user()->name ?? 'Admin' }}</strong>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="logout-btn">Sign out</button>
        </form>
    </div>
</header>
