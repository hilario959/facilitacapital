<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $site['seo']['title'] }}</title>
    <meta name="description" content="{{ $site['seo']['description'] }}">
    <meta property="og:title" content="{{ $site['seo']['title'] }}">
    <meta property="og:description" content="{{ $site['seo']['description'] }}">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <style>
        :root {
            @foreach (\App\Support\SiteContent::colorVariables($site['colors']) as $name => $value)
                --{{ $name }}: {{ $value }};
            @endforeach
        }
    </style>
</head>
<body @if (session('lead_sent')) data-lead-sent="1" @endif>
    @yield('content')
    <script src="{{ asset('js/site.js') }}" defer></script>
</body>
</html>
