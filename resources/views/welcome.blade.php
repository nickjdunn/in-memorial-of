<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Global & Example Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- Load the main site fonts first --}}
        <link href="{{ get_google_font_url() }}" rel="stylesheet">
        
        {{-- NEW: If an example memorial exists, also load its specific fonts --}}
        @if($exampleMemorial?->font_family_name && $exampleMemorial?->font_family_body)
            <link href="https://fonts.googleapis.com/css2?family={{ urlencode($exampleMemorial->font_family_name) }}:wght@400;700&family={{ urlencode($exampleMemorial->font_family_body) }}:wght@400;700&display=swap" rel="stylesheet">
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ route('css.dynamic') }}">
    </head>
    <body class="antialiased bg-gray-100">
        <div class="relative min-h-screen">
            <!-- Header -->
            <header class="absolute top-0 left-0 right-0 z-10 p-6">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="font-semibold text-2xl font-heading">
                        In Memorial Of
                    </div>
                    <div>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold hover:underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold hover:underline">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 font-semibold hover:underline">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </header>

            <main>
                <!-- Hero Section -->
                <section class="relative h-screen flex items-center justify-center text-center bg-white overflow-hidden">
                    <div class="absolute inset-0 bg-gray-50 opacity-50"></div>
                    <div class="relative z-10 p-8 max-w-3xl mx-auto">
                        <h1 class="text-4xl md:text-6xl font-bold font-heading">Honor a Life, Preserve a Legacy</h1>
                        <p class="mt-6 text-lg md:text-xl text-gray-600">
                            Create a beautiful, permanent, and shareable online memorial page. A dedicated space to celebrate the life and cherish the memories of your loved one.
                        </p>
                        <div class="mt-10">
                            <a href="{{ route('register') }}" class="button-link inline-block bg-brand-600 text-white font-bold text-lg py-4 px-10 rounded-lg shadow-lg hover:bg-brand-500 transition-transform transform hover:scale-105">
                                Get Started - ${{ config('app_settings.site_price') }}
                            </a>
                            <p class="mt-4 text-sm text-gray-500">Create an account to purchase one or more memorial pages.</p>
                        </div>
                    </div>
                </section>

                <!-- Example Memorial Section -->
                @if($exampleMemorial)
                <section class="py-20 bg-gray-50">
                    <div class="max-w-5xl mx-auto px-6 text-center">
                        <h2 class="text-3xl font-bold font-heading">A Lasting Tribute</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-gray-600">
                            Each page is a clean, respectful, and fully customizable space to share their story. View an example of a memorial page below.
                        </p>
                        <div class="mt-12 w-full p-6 md:p-10 bg-white shadow-xl overflow-hidden sm:rounded-lg text-left" style="border-top: 8px solid {{ $exampleMemorial->primary_color }};">
                            <div class="text-center">
                                <h3 class="text-3xl font-bold" style="color: {{ $exampleMemorial->primary_color }}; font-family: '{{ $exampleMemorial->font_family_name }}', serif;">In Loving Memory of</h3>
                                <h4 class="text-2xl mt-2" style="color: #111827; font-family: '{{ $exampleMemorial->font_family_name }}', serif;">{{ $exampleMemorial->full_name }}</h4>
                            </div>
                            <div class="mt-6 text-center text-gray-500" style="font-family: '{{ $exampleMemorial->font_family_body }}', sans-serif;">
                                @if($exampleMemorial->date_of_birth || $exampleMemorial->date_of_passing)
                                    <p>
                                        @if($exampleMemorial->date_of_birth)
                                            {{ \Carbon\Carbon::parse($exampleMemorial->date_of_birth)->format('F j, Y') }}
                                        @endif
                                        @if($exampleMemorial->date_of_birth && $exampleMemorial->date_of_passing)
                                            &mdash;
                                        @endif
                                        @if($exampleMemorial->date_of_passing)
                                            {{ \Carbon\Carbon::parse($exampleMemorial->date_of_passing)->format('F j, Y') }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                            
                            <div class="mt-8 flex justify-center">
                                @if ($exampleMemorial->profile_photo_path)
                                    <img src="{{ asset('storage/' . $exampleMemorial->profile_photo_path) }}" 
                                         alt="{{ $exampleMemorial->full_name }}" 
                                         class="w-40 h-40 object-cover shadow-xl border-4 border-white {{ $exampleMemorial->photo_shape }}">
                                @endif
                            </div>

                            <div class="mt-8 prose max-w-none text-gray-700 text-justify" style="font-family: '{{ $exampleMemorial->font_family_body }}', sans-serif;">
                                {!! $exampleMemorial->biography !!}
                            </div>
                            <div class="mt-8 text-center">
                                <a href="{{ route('memorials.show_public', $exampleMemorial->slug) }}" target="_blank" class="font-semibold" style="color: {{ $exampleMemorial->primary_color }};">View Full Memorial →</a>
                            </div>
                        </div>
                    </div>
                </section>
                @endif
            </main>

            <!-- Footer -->
            <footer class="bg-white py-12">
                <div class="max-w-7xl mx-auto px-6 text-center">
                     <div class="font-semibold text-2xl font-heading mb-4">
                        In Memorial Of
                    </div>
                    <p class="text-gray-500">Preserving memories for generations to come.</p>
                    <p class="text-xs text-gray-400 mt-8">&copy; {{ date('Y') }}. All Rights Reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>