<footer class="pub-footer">
    <div class="container">
        <div class="pub-footer-grid">

            {{-- Column 1: Brand --}}
            <div class="pub-footer-brand">
                <a href="{{ url('/') }}" class="pub-logo">Guhanga<span>Akazi</span></a>
                <p>Business ideas, skills, and opportunities to help people become self-employed.</p>
            </div>

            {{-- Column 2: Explore --}}
            <div>
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ route('public.ideas') }}">Business Ideas</a></li>
                    <li><a href="{{ route('public.skills') }}">Skills</a></li>
                    <li><a href="{{ route('public.opportunities') }}">Opportunities</a></li>
                    <li><a href="{{ route('public.articles') }}">Articles</a></li>
                </ul>
            </div>

            {{-- Column 3: Media --}}
            <div>
                <h4>Media</h4>
                <ul>
                    <li><a href="{{ route('public.photos') }}">Photos</a></li>
                    <li><a href="{{ route('public.videos') }}">Videos</a></li>
                    <li><a href="{{ route('public.search') }}">Search</a></li>
                </ul>
            </div>

            {{-- Column 4: Company --}}
            <div>
                <h4>Company</h4>
                <ul>
                    <li><a href="{{ route('public.about') }}">About Us</a></li>
                    <li><a href="{{ route('public.contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('public.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('public.terms') }}">Terms of Use</a></li>
                </ul>
            </div>

        </div>

        <div class="pub-footer-bottom">
            &copy; {{ date('Y') }} GuhangaAkazi. All rights reserved.
        </div>
    </div>
</footer>
