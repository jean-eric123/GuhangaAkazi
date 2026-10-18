<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', 'GuhangaAkazi')</title>
    <meta name="description" content="@yield('meta_description', 'Business ideas, skills and opportunities in Rwanda.')">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    @stack('head')
</head>
<body>
    @include('public.partials.header')
    <main class="pub-main">@yield('content')</main>
    @include('public.partials.footer')
    @stack('scripts')
</body>
</html>