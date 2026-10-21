<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "GuhangaAkazi")</title>
    <link rel="stylesheet" href="{{ asset("css/public.css") }}">
</head>
<body>
    @include("public.partials.header")

    <main>
        @yield("content")
    </main>

    @include("public.partials.footer")
</body>
</html>