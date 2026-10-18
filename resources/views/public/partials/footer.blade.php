<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="{{ route('public.home') }}" class="footer-logo" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #fff; font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">
                    <svg width="32" height="32" viewBox="0 0 32 32"><rect width="32" height="32" rx="8" fill="#0B6B4F"/><path d="M8 22V16M13 22V12M18 22V18M23 22V9" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/></svg>
                    GuhangaAkazi
                </a>
                <p style="color: #9ca3af; font-size: 0.95rem; line-height: 1.6;">Business ideas, skills, and opportunities to help people become self-employed.</p>
            </div>
            <div class="footer-col">
                <h4 style="color: #fff; font-size: 1rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Explore</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.home') }}" style="color: #9ca3af; text-decoration: none;">Home</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.ideas') }}" style="color: #9ca3af; text-decoration: none;">Business Ideas</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.skills') }}" style="color: #9ca3af; text-decoration: none;">Skills</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.opportunities') }}" style="color: #9ca3af; text-decoration: none;">Opportunities</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.articles') }}" style="color: #9ca3af; text-decoration: none;">Articles</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 style="color: #fff; font-size: 1rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Media</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.photos') }}" style="color: #9ca3af; text-decoration: none;">Photos</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.videos') }}" style="color: #9ca3af; text-decoration: none;">Videos</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.search') }}" style="color: #9ca3af; text-decoration: none;">Search</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 style="color: #fff; font-size: 1rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Company</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.about') }}" style="color: #9ca3af; text-decoration: none;">About Us</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.contact') }}" style="color: #9ca3af; text-decoration: none;">Contact Us</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.privacy') }}" style="color: #9ca3af; text-decoration: none;">Privacy</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="{{ route('public.terms') }}" style="color: #9ca3af; text-decoration: none;">Terms</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top: 1px solid #374151; margin-top: 2rem; padding-top: 1rem; text-align: center; color: #6c7280; font-size: 0.85rem;">
            &copy; {{ date('Y') }} GuhangaAkazi. All rights reserved.
        </div>
    </div>
</footer>
<style>
.site-footer { background-color: #111827; padding: 3rem 0; color: #fff; font-family: inherit; }
.footer-grid { display: grid; gap: 2rem; grid-template-columns: 1fr; }
@media (min-width: 768px) { .footer-grid { grid-template-columns: repeat(4, 1fr); } }
.site-footer a:hover { color: #0B6B4F !important; }
</style>