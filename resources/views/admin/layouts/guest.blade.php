<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name', 'GuhangaAkazi') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f1f5f4;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
            width: 100%;
            max-width: 420px;
            padding: 2rem 1.75rem;
        }
        .brand {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .brand h1 {
            margin: 0;
            color: #0B6B4F;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .brand p {
            margin: 0.25rem 0 0;
            color: #64748b;
            font-size: 0.875rem;
        }
        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
            color: #334155;
        }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 1rem;
            background: #fff;
            color: #1e293b;
        }
        input:focus {
            outline: none;
            border-color: #0B6B4F;
            box-shadow: 0 0 0 3px rgba(11,107,79,.15);
        }
        button {
            width: 100%;
            padding: 0.85rem;
            background: #0B6B4F;
            color: #fff;
            border: 0;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        button:hover { background: #095c43; }
        .errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        .errors ul { margin: 0; padding-left: 1.25rem; }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #475569;
        }
        .footer-note {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: #94a3b8;
        }
        @media (max-width: 480px) {
            .card { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="card">
        @yield('content')
    </div>
</body>
</html>
