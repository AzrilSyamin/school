<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ \App\Models\Setting::get('site_title', config('app.name', 'EduFlow')) }}</title>
    <link rel="icon" type="image/x-icon"
        href="{{ \App\Models\Setting::get('site_favicon') ? (\Illuminate\Support\Str::startsWith(\App\Models\Setting::get('site_favicon'), 'settings/') ? asset('storage/' . \App\Models\Setting::get('site_favicon')) : asset(\App\Models\Setting::get('site_favicon'))) : asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead
    <script>
        (function() {
            const storedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = storedTheme || systemTheme;
            document.documentElement.className = theme;
        })();
    </script>
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
