<x-memorial-layout>
    <x-slot name="title">{{ $memorial->full_name }}</x-slot>

    @push('head')
        @if($memorial->font_family_name && $memorial->font_family_body)
            <link href="https://fonts.googleapis.com/css2?family={{ urlencode($memorial->font_family_name) }}:wght@400;700&family={{ urlencode($memorial->font_family_body) }}:wght@400;700&display=swap" rel="stylesheet">
        @endif
    @endpush

    <div class="min-h-screen py-8 sm:py-12 px-4">

        <div class="w-full max-w-4xl mx-auto p-6 md:p-12 bg-white shadow-2xl overflow-hidden sm:rounded-lg"
             style="border-top: 8px solid {{ $memorial->primary_color }};">
            
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold" 
                    style="color: {{ $memorial->primary_color }}; font-family: '{{ $memorial->font_family_name }}', serif;">
                    In Loving Memory of
                </h1>
                <h2 class="text-2xl sm:text-3xl md:text-4xl mt-2"
                    style="color: #111827; font-family: '{{ $memorial->font_family_name }}', serif;">
                    {{ $memorial->full_name }}
                </h2>
            </div>

            @if($memorial->date_of_birth || $memorial->date_of_passing)
                <div class="mt-8 text-center text-gray-500" style="font-family: '{{ $memorial->font_family_body }}', sans-serif;">
                    <p>
                        @if($memorial->date_of_birth)
                            {{ \Carbon\Carbon::parse($memorial->date_of_birth)->format('F j, Y') }}
                        @endif
                        @if($memorial->date_of_birth && $memorial->date_of_passing)
                            &mdash;
                        @endif
                        @if($memorial->date_of_passing)
                            {{ \Carbon\Carbon::parse($memorial->date_of_passing)->format('F j, Y') }}
                        @endif
                    </p>
                </div>
            @endif

            <div class="mt-8 flex justify-center">
                @if ($memorial->profile_photo_path)
                    <img src="{{ asset('storage/' . $memorial->profile_photo_path) }}" 
                         alt="{{ $memorial->full_name }}" 
                         class="w-40 h-40 sm:w-48 sm:h-48 md:w-64 md:h-64 object-cover shadow-xl border-4 border-white {{ $memorial->photo_shape }}">
                @endif
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="ql-snow">
                    <div class="ql-editor" style="font-family: '{{ $memorial->font_family_body }}', sans-serif; padding: 0;">
                        {!! $memorial->biography !!}
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="w-full max-w-4xl mx-auto text-center text-gray-500 py-6 mt-4 px-6">
            <p>&copy; {{ date('Y') }} In Memorial Of. All Rights Reserved.</p>
            <p class="text-sm mt-2"><a href="{{ url('/') }}" class="hover:underline" style="color: {{ $memorial->primary_color }}">Create a memorial page for your loved one.</a></p>
        </footer>

    </div>
</x-memorial-layout>