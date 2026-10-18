<header class="pub-header">
    <div class="container pub-header-inner">
        <a href="{{ url('/') }}" class="pub-logo">
            <svg width="32" height="32" viewBox="0 0 32 32"><rect width="32" height="32" rx="8" fill="#0B6B4F"/><path d="M8 22V16M13 22V12M18 22V18M23 22V9" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/></svg>
            <span class="pub-logo-text">Guhanga<span style="color: #0B6B4F;">Akazi</span></span>
        </a>

        {{-- Desktop Search --}}
        <form action="{{ route('public.search') }}" method="GET" class="pub-search-desktop">
            <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
            <button type="submit"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="m21 21-4-4"/></svg></button>
        </form>

        <!-- Mobile Actions -->
        <div class="pub-mobile-actions">
            <a href="{{ route('public.search') }}" class="pub-mobile-search-icon" aria-label="Search">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="m21 21-4-4"/></svg>
            </a>
            <button class="pub-mobile-toggle" id="pubMenuToggle" aria-label="Menu">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            </button>
        </div>

        <nav class="pub-nav" id="pubNav">
            <a href="{{ url('/') }}" class="nav-icon-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg> Home</a>
            <a href="{{ route('public.ideas') }}">Ideas</a>
            <a href="{{ route('public.skills') }}">Skills</a>
            <a href="{{ route('public.opportunities') }}">Opportunities</a>
            <a href="{{ route('public.articles') }}">Articles</a>
            <a href="{{ route('public.photos') }}">Photos</a>
            <a href="{{ route('public.videos') }}">Videos</a>
            <a href="{{ route('public.about') }}">About Us</a>
            <a href="{{ route('public.contact') }}">Contact Us</a>
        </nav>
    </div>
</header>

<script>
    (function() {
        var t = document.getElementById('pubMenuToggle');
        var n = document.getElementById('pubNav');
        if (t && n) {
            t.addEventListener('click', function (e) { e.stopPropagation(); n.classList.toggle('open'); });
            document.addEventListener('click', function(e) {
                if (n.classList.contains('open') && !n.contains(e.target) && !t.contains(e.target)) n.classList.remove('open');
            });
            // Fix: Automatically close the menu when rotating to landscape
            window.addEventListener('orientationchange', function() {
                n.classList.remove('open');
            });
        }
    })();
</script>