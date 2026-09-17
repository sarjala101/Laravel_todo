<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name', 'Todo App') }}</title>

    @vite (['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 antialiased">
    {{-- Global toast --}}
    @if (session()->has('toast'))
        <div
            data-toast
            data-toast-type="{{ session('toast.type') }}"
            data-toast-message="{{ session('toast.message') }}"
            class="hidden"
        ></div>
    @endif

    {{ $slot }}

    @livewireScripts
</body>
</html>
