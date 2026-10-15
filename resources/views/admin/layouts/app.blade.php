<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name', 'GuhangaAkazi') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin">
    <div class="admin-wrap">
        @include('admin.partials.sidebar')

        <div class="admin-main">
            @include('admin.partials.header')

            <main class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin:0; padding-left:1.25rem">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            var toggle   = document.getElementById('menuToggle');
            var sidebar  = document.getElementById('adminSidebar');
            var backdrop = document.getElementById('sidebarBackdrop');

            function close() {
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
            }

            toggle && toggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
                backdrop.classList.toggle('open');
            });

            backdrop && backdrop.addEventListener('click', close);
        })();
    </script>
</body>
</html>
