<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', 'GuhangaAkazi')</title>
    
    <!-- FORCE BROWSER TO RELOAD CSS -->
    <link rel="stylesheet" href="{{ asset('css/public.css') }}?v={{ time() }}">
</head>
<body>

    @include('public.partials.header')

    <main>
        @yield('content')
    </main>

    @include('public.partials.footer')

</body>
</html>
