<header class="pub-header">
    <div class="container">
        <div class="pub-header-inner">

            {{-- Logo with icon --}}
            <a href="{{ url('/') }}" class="pub-logo">
                <svg class="pub-logo-icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="#0B6B4F"/>
                    <path d="M8 22V16M13 22V12M18 22V18M23 22V9" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M7 11L13 7L19 10L25 5" stroke="#7dd3a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
                <span class="pub-logo-text">Guhanga<span>Akazi</span></span>
            </a>

            {{-- Desktop search --}}
            <form action="{{ route('public.search') }}" method="GET" class="pub-search-desktop">
                <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                <button type="submit" aria-label="Search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="m21 21-4-4"/></svg>
                </button>
            </form>

            {{-- Hamburger --}}
            <button class="pub-mobile-toggle" id="pubMenuToggle" aria-label="Menu">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            </button>

            {{-- Nav --}}
            <nav class="pub-nav" id="pubNav">
                <a href="{{ url('/') }}" class="nav-icon-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/>
                    </svg>
                    Home
                </a>
                <a href="{{ route('public.ideas') }}">Ideas</a>
                <a href="{{ route('public.skills') }}">Skills</a>
                <a href="{{ route('public.opportunities') }}">Opportunities</a>
                <a href="{{ route('public.articles') }}">Articles</a>
                <a href="{{ route('public.photos') }}">Photos</a>
                <a href="{{ route('public.videos') }}">Videos</a>
                <a href="{{ route('public.about') }}">About Us</a>
                <a href="{{ route('public.contact') }}">Contact Us</a>
                <a href="{{ route('public.search') }}">Search</a>

                <form action="{{ route('public.search') }}" method="GET" class="pub-search-mobile">
                    <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                    <button type="submit" aria-label="Search">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="m21 21-4-4"/></svg>
                    </button>
                </form>
            </nav>

        </div>
    </div>
</header>

<script>
    var toggle = document.getElementById('pubMenuToggle');
    var nav = document.getElementById('pubNav');
    if (toggle && nav) {
        toggle.addEventListener('click', function (e) { e.stopPropagation(); nav.classList.toggle('open'); });
        document.addEventListener('click', function(e) {
            if (nav.classList.contains('open') && !nav.contains(e.target) && !toggle.contains(e.target)) nav.classList.remove('open');
        });
    }
</script>
