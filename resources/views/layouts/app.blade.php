<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @seo
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body x-data="{ 'showTaskUploadModal': false, 'showTaskEditModal': false }" x-cloak>
<livewire:flash-livewire-message/>
@include('shared.flash')
@include('shared.header')
<main class="py-16 lg:py-20">
    <div class="container">
        @yield('content')
    </div>
</main>
@include('shared.footer')
@livewireScriptConfig
</body>
</html>
