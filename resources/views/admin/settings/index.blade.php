<x-app-layout>
    @push('head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- Expanded font list for live previews --}}
        <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;700&family=Roboto:wght@400;700&family=Lato:wght@400;700&family=Montserrat:wght@400;700&family=Open+Sans:wght@400;700&family=Lora:wght@400;700&family=Merriweather:wght@400;700&family=Playfair+Display:wght@400;700&family=Source+Serif+4:wght@400;700&family=Nunito:wght@400;700&family=Poppins:wght@400;700&family=Inter:wght@400;700&family=Raleway:wght@400;700&family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Site Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    <div class="p-6 md:p-8 text-gray-900">
                        
                        {{-- Two-column layout for Colors and Typography --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- Column 1: All Color Settings --}}
                            <div class="space-y-6">
                                <h3 class="text-xl font-bold font-heading border-b pb-2">Theme Colors</h3>
                                
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-700 font-heading">Header & Navigation</h4>
                                    @php
                                        $headerColors = [
                                            ['name' => 'header_bg_color', 'label' => 'Header Background'],
                                            ['name' => 'header_text_color', 'label' => 'Header Title Text'],
                                            ['name' => 'nav_link_color', 'label' => 'Nav Link'],
                                            ['name' => 'nav_link_hover_color', 'label' => 'Nav Link Hover'],
                                            ['name' => 'nav_link_active_color', 'label' => 'Nav Link Active'],
                                        ];
                                    @endphp
                                    @foreach ($headerColors as $color)
                                    <div>
                                        <label for="{{ $color['name'] }}_text" class="block text-sm font-medium text-gray-700">{{ $color['label'] }}</label>
                                        <div class="mt-1 flex items-center space-x-3">
                                            <input type="color" id="{{ $color['name'] }}_picker" value="{{ old($color['name'], $settings[$color['name']]) }}" class="h-10 w-10 p-1 border-gray-300 rounded-md" data-text-input-id="{{ $color['name'] }}_text">
                                            <input type="text" id="{{ $color['name'] }}_text" name="{{ $color['name'] }}" value="{{ old($color['name'], $settings[$color['name']]) }}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" data-color-picker-id="{{ $color['name'] }}_picker">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="space-y-4 pt-4 border-t">
                                    <h4 class="font-semibold text-gray-700 font-heading">General Page Elements</h4>
                                    @php
                                        $generalColors = [
                                            ['name' => 'primary_color_500', 'label' => 'Button & Accent Color'],
                                            ['name' => 'text_color_base', 'label' => 'Base Text Color'],
                                            ['name' => 'text_color_heading', 'label' => 'Heading Text Color'],
                                            ['name' => 'link_color', 'label' => 'Content Link Color'],
                                            ['name' => 'link_hover_color', 'label' => 'Content Link Hover Color'],
                                        ];
                                    @endphp
                                    @foreach ($generalColors as $color)
                                    <div class="mt-4">
                                        <label for="{{ $color['name'] }}_text" class="block text-sm font-medium text-gray-700">{{ $color['label'] }}</label>
                                        <div class="mt-1 flex items-center space-x-3">
                                            <input type="color" id="{{ $color['name'] }}_picker" value="{{ old($color['name'], $settings[$color['name']]) }}" class="h-10 w-10 p-1 border-gray-300 rounded-md" data-text-input-id="{{ $color['name'] }}_text">
                                            <input type="text" id="{{ $color['name'] }}_text" name="{{ $color['name'] }}" value="{{ old($color['name'], $settings[$color['name']]) }}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" data-color-picker-id="{{ $color['name'] }}_picker">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Column 2: Typography Settings --}}
                            <div class="space-y-6">
                                <h3 class="text-xl font-bold font-heading border-b pb-2">Typography</h3>
                                <p class="mt-1 text-sm text-gray-600">Choose the fonts for the website from Google Fonts.</p>

                                @php
                                    $fonts = [
                                        'Arimo', 'Asap', 'Cabin', 'Dosis', 'Figtree', 'Fira Sans', 'Inter',
                                        'Josefin Sans', 'Lato', 'Montserrat', 'Mulish', 'Nunito', 'Open Sans',
                                        'Poppins', 'Quicksand', 'Raleway', 'Roboto',
                                        'Alegreya', 'Bitter', 'Cardo', 'Cormorant Garamond', 'Crimson Text',
                                        'Libre Baskerville', 'Lora', 'Merriweather', 'Noto Serif', 'Playfair Display',
                                        'PT Serif', 'Source Serif 4',
                                    ];
                                    sort($fonts);
                                    
                                    $fontSettings = [
                                        ['name' => 'font_family_base', 'label' => 'Base Text Font'],
                                        ['name' => 'font_family_headings', 'label' => 'Headings Font'],
                                    ];
                                @endphp

                                @foreach ($fontSettings as $fontSetting)
                                <div>
                                    <label for="{{ $fontSetting['name'] }}" class="block text-sm font-medium text-gray-700">{{ $fontSetting['label'] }}</label>
                                    <select id="{{ $fontSetting['name'] }}" name="{{ $fontSetting['name'] }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" data-preview-id="{{ $fontSetting['name'] }}_preview">
                                        @foreach ($fonts as $font)
                                            <option value="{{ $font }}" 
                                                    style="font-family: '{{ $font }}', sans-serif; font-size: 1rem;"
                                                    @selected(old($fontSetting['name'], $settings[$fontSetting['name']]) == $font)>
                                                {{ $font }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="{{ $fontSetting['name'] }}_preview" class="mt-2 p-4 bg-gray-100 rounded-md text-lg">
                                        The quick brown fox jumps over the lazy dog.
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="flex items-center justify-end p-6 bg-gray-50 border-t border-gray-200">
                        <x-primary-button>
                            {{ __('Save Settings') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Real-time Color Picker and Text Input Sync ---
            const colorPickers = document.querySelectorAll('input[type="color"]');
            const textInputs = document.querySelectorAll('input[type="text"][data-color-picker-id]');

            colorPickers.forEach(picker => {
                picker.addEventListener('input', (event) => {
                    const textInputId = event.target.dataset.textInputId;
                    if (textInputId) {
                        document.getElementById(textInputId).value = event.target.value;
                    }
                });
            });

            textInputs.forEach(input => {
                input.addEventListener('input', (event) => {
                    const colorPickerId = event.target.dataset.colorPickerId;
                    if (colorPickerId) {
                        document.getElementById(colorPickerId).value = event.target.value;
                    }
                });
            });

            // --- Real-time Font Preview ---
            const fontSelects = document.querySelectorAll('select[data-preview-id]');
            
            function updateFontPreview(selectElement) {
                const previewId = selectElement.dataset.previewId;
                const previewElement = document.getElementById(previewId);
                if (previewElement) {
                    previewElement.style.fontFamily = `'${selectElement.value}', sans-serif`;
                }
            }

            fontSelects.forEach(select => {
                updateFontPreview(select);
                select.addEventListener('change', (event) => {
                    updateFontPreview(event.target);
                });
            });
        });
    </script>
    @endpush
</x-app-layout>