<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Dynamic Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="{{ get_google_font_url() }}" rel="stylesheet">
        
        <!-- Trix Editor Assets -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js" defer></script>

        <!-- Scripts & Static Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Dynamic Color Styles -->
        <link rel="stylesheet" href="{{ route('css.dynamic') }}">

        @stack('head')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            <div class="unified-header shadow">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @if (isset($header))
                    <header>
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
            </div>

            @if (request()->routeIs('admin.*'))
                @include('layouts.admin-navigation')
            @endif

            <!-- Page Content -->
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
        
        @stack('scripts')
    </body>
</html>