<style>
    .ga-header { background-color: #ffffff; color: #0f172a; position: sticky; top: 0; z-index: 1000; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-bottom: 1px solid #e2e8f0; }
    .ga-container { max-width: 1200px; margin: 0 auto; padding: 0.75rem 1rem; box-sizing: border-box; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
    .ga-logo { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #0B6B4F; font-weight: 800; font-size: 1.4rem; white-space: nowrap; }
    .ga-logo-icon { background: #0B6B4F; color: white; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    
    .ga-actions { display: flex; align-items: center; gap: 0.5rem; }
    .ga-icon-btn { background: none; border: none; color: #0f172a; cursor: pointer; padding: 0.5rem; display: flex; align-items: center; justify-content: center; }
    
    /* Search Dropdown */
    .search-overlay { display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 999; }
    .search-overlay.active { display: block; }
    .search-input-wrapper { max-width: 600px; margin: 0 auto; display: flex; align-items: center; background: #f1f5f9; border-radius: 8px; overflow: hidden; }
    .search-input-wrapper input { flex-grow: 1; padding: 0.75rem 1rem; border: none; outline: none; background: transparent; font-size: 0.95rem; }
    .search-input-wrapper button { background: transparent; border: none; padding: 0 1rem; color: #64748b; cursor: pointer; }
    #live-search-results { max-width: 600px; margin: 0.5rem auto 0; max-height: 300px; overflow-y: auto; background: white; border-radius: 8px; }
    .search-result-item { display: block; padding: 0.75rem 1rem; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: #0f172a; }
    .search-result-item:hover { background: #f8fafc; }
    
    .ga-nav { background-color: #ffffff; border-top: 1px solid #e2e8f0; display: none; width: 100%; }
    .ga-nav.active { display: block; }
    .ga-nav-links { max-width: 1200px; margin: 0 auto; padding: 0.5rem 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
    .ga-nav-links a { color: #475569; text-decoration: none; font-weight: 600; padding: 0.5rem 0.75rem; display: flex; align-items: center; border-radius: 6px; font-size: 0.95rem; }
    .ga-nav-links a:hover { color: #0B6B4F; background: #f1f5f9; }

    @media (max-width: 767px) {
        .ga-nav-links { flex-direction: column; align-items: flex-start; }
        .ga-nav-links a { width: 100%; padding: 0.8rem 0.5rem; border-bottom: 1px solid #f1f5f9; }
    }
    @media (min-width: 768px) { .ga-nav { display: block !important; border-top: none; background: transparent; width: auto; } .ga-nav-links { padding: 0; } }
</style>

<header class="ga-header" style="position: relative;">
    <div class="ga-container">
        <a href="{{ route('public.home') }}" class="ga-logo">
            <div class="ga-logo-icon">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            GuhangaAkazi
        </a>

        <div class="ga-actions">
            <button class="ga-icon-btn" onclick="toggleSearch()">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
            <button class="ga-icon-btn" onclick="document.getElementById('ga-mobile-menu').classList.toggle('active')">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>

    <!-- Search Overlay -->
    <div id="search-overlay" class="search-overlay">
        <div class="search-input-wrapper">
            <input type="text" id="live-search-input" placeholder="Search ideas, skills..." autocomplete="off">
            <button onclick="document.getElementById('search-overlay').classList.remove('active')">✕</button>
        </div>
        <div id="live-search-results"></div>
    </div>

    <nav id="ga-mobile-menu" class="ga-nav">
        <div class="ga-nav-links">
            <a href="{{ route('public.home') }}">Home</a>
            <a href="{{ route('public.ideas') }}">Ideas</a>
            <a href="{{ route('public.skills') }}">Skills</a>
            <a href="{{ route('public.opportunities') }}">Opportunities</a>
            <a href="{{ route('public.articles') }}">Articles</a>
            <a href="{{ route('public.photos') }}">Photos</a>
            <a href="{{ route('public.videos') }}">Videos</a>
            <a href="{{ route('public.about') }}">About Us</a>
            <a href="{{ route('public.contact') }}">Contact Us</a>
        </div>
    </nav>
</header>

<script>
    function toggleSearch() {
        document.getElementById('search-overlay').classList.toggle('active');
        if(document.getElementById('search-overlay').classList.contains('active')) {
            document.getElementById('live-search-input').focus();
        }
    }

    let searchTimeout;
    document.getElementById('live-search-input').addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        const query = this.value;
        const resultsContainer = document.getElementById('live-search-results');
        
        if(query.length < 2) { resultsContainer.innerHTML = ''; return; }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('public.search') }}?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => { resultsContainer.innerHTML = data.html; });
        }, 300);
    });
</script>