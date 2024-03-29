<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body>
<livewire:flash-livewire-message/>
@include('shared.header')
<main class="py-16 lg:py-20">
    <div class="container">
        {{ $slot }}
    </div>
</main>
@include('shared.footer')
@livewireScriptConfig
</body>
</html>
