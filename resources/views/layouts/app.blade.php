<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Подключаем стили через asset() --}}
    <link rel="stylesheet" href="{{ asset('CSS/admin/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/admin/styles.css') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <header class="page-header">
            <h1 class="page-header__title">Идём<span>в</span>кино</h1>
            <span class="page-header__subtitle">Администраторррская</span>
        </header>

        <!-- Page Content -->
        <main class="conf-steps">
            {{ $slot }}
        </main>
        <script src="{{ asset('js/admin/accordeon.js') }}"></script>
    </div>
</body>

</html>