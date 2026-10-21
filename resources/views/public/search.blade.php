@extends("public.layouts.app")
@section("content")
<div class="container" style="padding: 4rem 1rem; max-width: 900px; margin: 0 auto;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 2rem; text-align: center;">Search</h1>

    @if(isset($q) && $q != '')
        <p style="text-align: center; color: #6b7280; margin-bottom: 3rem;">Showing results for: <strong style="color: #111827;">"{{ $q }}"</strong></p>
    @else
        <p style="text-align: center; color: #6b7280; margin-bottom: 3rem;">Enter a keyword to search ideas, skills, and opportunities.</p>
        <form action="{{ route('public.search') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 600px; margin: 0 auto 3rem auto;">
            <input type="text" name="q" placeholder="Search..." style="flex-grow: 1; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 6px; outline: none;" required>
            <button type="submit" style="background: #0B6B4F; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">Search</button>
        </form>
    @endif

    <div id="search-results">
        @if(isset($q) && $q != '')
            @include('public.partials.search-results')
        @endif
    </div>
</div>
@endsection