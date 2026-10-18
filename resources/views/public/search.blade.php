@extends('public.layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 2rem auto; padding: 0 1rem;">
    <!-- Search Bar (Instagram Style) -->
    <form action="{{ route('public.search') }}" method="GET" style="background: #efefef; border-radius: 8px; padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;" onsubmit="return false;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8e8e8e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="live-search-input" name="q" value="{{ request('q') }}" placeholder="Search" style="border: none; background: transparent; outline: none; width: 100%; font-size: 1rem; color: #262626;" autofocus autocomplete="off">
    </form>

    <!-- Results Container -->
    <div id="search-results-container">
        @include('public.partials.search-results', ['q' => request('q'), 'ideas' => $ideas ?? collect(), 'skills' => $skills ?? collect(), 'opportunities' => $opportunities ?? collect(), 'videos' => $videos ?? collect()])
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('live-search-input');
        const resultsContainer = document.getElementById('search-results-container');
        let timeout = null;

        input.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value.trim();

            timeout = setTimeout(() => {
                fetch(`{{ route('public.search') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = data.html;
                })
                .catch(error => console.error('Error:', error));
            }, 300); // Wait 300ms after user stops typing
        });
    });
</script>
@stop