<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name', 'GuhangaAkazi') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <style>
        /* Force responsive fixes on mobile */
        @media (max-width: 900px) {
            .admin-wrap { display: block !important; }
            .admin-sidebar { display: none; position: fixed; z-index: 9999; top: 0; left: 0; height: 100vh; width: 260px; }
            .admin-sidebar.open { display: block; }
            .admin-main { width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .admin-content { padding: 1rem !important; width: 100% !important; overflow-x: hidden; }
            .admin-header { padding: .5rem !important; }
            form { max-width: 100% !important; }
            input, select, textarea, button { max-width: 100% !important; box-sizing: border-box; }
            table { display: block; overflow-x: auto; white-space: nowrap; max-width: 100%; }
        }
    </style>
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

            if (toggle) {
                toggle.addEventListener('click', function () {
                    sidebar.classList.toggle('open');
                    backdrop.classList.toggle('open');
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', close);
            }
        })();
    </script>
</body>
</html>
