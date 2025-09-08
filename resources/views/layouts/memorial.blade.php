<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>In Memory of {{ $title ?? 'a Loved One' }} | {{ config('app.name', 'Laravel') }}</title>

        <!-- Dynamic Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        @stack('head')

        <!-- QuillJS Theme for rendering content -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

        <!-- Scripts & Static Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Dynamic Color Styles -->
        <link rel="stylesheet" href="{{ route('css.dynamic') }}">
    </head>
    <body class="font-sans antialiased memorial-page-bg">
        {{ $slot }}
    </body>
</html>