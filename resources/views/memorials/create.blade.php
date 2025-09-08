<x-app-layout>
    @push('head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya&family=Asap&family=Bitter&family=Cabin&family=Caveat&family=Cormorant+Garamond&family=Crimson+Text&family=Dancing+Script&family=Domine&family=EB+Garamond&family=Figtree&family=Inter&family=Kalam&family=Lato&family=Libre+Baskerville&family=Lora&family=Merriweather&family=Montserrat&family=Mulish&family=Nunito&family=Open+Sans&family=Patrick+Hand&family=Playfair+Display&family=Poppins&family=PT+Serif&family=Raleway&family=Roboto&family=Source+Serif+4&family=Work+Sans&display=swap" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ isset($userFor) ? 'Create Memorial for ' . $userFor->name : 'Create Memorial Page' }}
        </h2>
    </x-slot>
    <div class="py-12 main-content">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <form id="memorial-form" method="POST" action="{{ route('memorials.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    @isset($userFor)
                        <input type="hidden" name="user_id" value="{{ $userFor->id }}">
                    @endisset

                    <div class="p-6 md:p-8 space-y-6">
                        
                        {{-- Memorial Information Section --}}
                        <div>
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Memorial Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="full_name" value="Full Name" />
                                    <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus />
                                    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Beginning Date --}}
                                    <div>
                                        <x-input-label value="Beginning Date (Optional)" />
                                        <div class="flex space-x-2 mt-1">
                                            <select name="birth_month" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Month</option>
                                                @foreach(range(1, 12) as $month)
                                                    <option value="{{ $month }}" @selected(old('birth_month') == $month)>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                                                @endforeach
                                            </select>
                                            <select name="birth_day" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Day</option>
                                                @foreach(range(1, 31) as $day)
                                                    <option value="{{ $day }}" @selected(old('birth_day') == $day)>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                            <select name="birth_year" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Year</option>
                                                @foreach(range(date('Y'), 1800) as $year)
                                                    <option value="{{ $year }}" @selected(old('birth_year') == $year)>{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                    </div>
                                    {{-- Ending Date --}}
                                    <div>
                                        <x-input-label value="Ending Date (Optional)" />
                                        <div class="flex space-x-2 mt-1">
                                            <select name="passing_month" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Month</option>
                                                @foreach(range(1, 12) as $month)
                                                    <option value="{{ $month }}" @selected(old('passing_month') == $month)>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                                                @endforeach
                                            </select>
                                            <select name="passing_day" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Day</option>
                                                @foreach(range(1, 31) as $day)
                                                    <option value="{{ $day }}" @selected(old('passing_day') == $day)>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                            <select name="passing_year" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Year</option>
                                                @foreach(range(date('Y'), 1800) as $year)
                                                    <option value="{{ $year }}" @selected(old('passing_year') == $year)>{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('date_of_passing')" class="mt-2" />
                                    </div>
                                </div>
                                
                                {{-- Biography Section for QuillJS --}}
                                <div>
                                    <x-input-label for="biography" value="Biography / Life Story" />
                                    <input name="biography" type="hidden">
                                    <div id="editor-container" class="mt-1">
                                        {!! old('biography') !!}
                                    </div>
                                    <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Profile Photo Section --}}
                        <div class="pt-6 border-t">
                             <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Profile Photo</h3>
                             <div class="flex items-center space-x-6">
                                <img id="photo-preview" src="https://via.placeholder.com/96/f3f4f6/cbd5e1?text=Photo" alt="Profile photo preview" 
                                     class="h-24 w-24 object-cover transition-all duration-300 ease-in-out rounded-full">
                                <div>
                                    <x-input-label for="profile_photo" value="Profile Photo" />
                                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                                           onchange="document.getElementById('photo-preview').src = window.URL.createObjectURL(this.files[0])"
                                           class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Theme Customization Section --}}
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Page Theme & Appearance</h3>
                            <div class="space-y-6">
                                @php
                                    $photoShapes = [
                                        ['value' => 'rounded-full', 'label' => 'Circle'],
                                        ['value' => 'rounded-2xl', 'label' => 'Rounded Square'],
                                        ['value' => '', 'label' => 'Square'],
                                        ['value' => 'shape-diamond', 'label' => 'Diamond'],
                                        ['value' => 'shape-octagon', 'label' => 'Octagon'],
                                        ['value' => 'shape-heart', 'label' => 'Heart'],
                                        ['value' => 'shape-cross', 'label' => 'Cross'],
                                    ];
                                @endphp

                                {{-- Primary Color --}}
                                <div>
                                    <x-input-label for="primary_color" value="Accent Color" />
                                    <div class="mt-1 flex items-center space-x-3">
                                        <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', '#0d9488') }}" class="h-10 w-10 p-1 border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                                    </div>
                                </div>

                                {{-- Name Font --}}
                                <div>
                                    <x-input-label for="font_family_name" value="Name & Title Font" />
                                    <select id="font_family_name" name="font_family_name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach (config('fonts.options') as $group => $fonts)
                                            <optgroup label="{{ $group }}">
                                                @foreach ($fonts as $font)
                                                    <option value="{{ $font }}" 
                                                            style="font-family: '{{ $font }}', sans-serif; font-size: 1.1rem;"
                                                            @selected(old('font_family_name', 'Playfair Display') == $font)>
                                                        {{ $font }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('font_family_name')" class="mt-2" />
                                </div>

                                {{-- Body Font --}}
                                <div>
                                    <x-input-label for="font_family_body" value="Biography Font" />
                                    <select id="font_family_body" name="font_family_body" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach (config('fonts.options') as $group => $fonts)
                                            <optgroup label="{{ $group }}">
                                                @foreach ($fonts as $font)
                                                    <option value="{{ $font }}" 
                                                            style="font-family: '{{ $font }}', sans-serif; font-size: 1.1rem;"
                                                            @selected(old('font_family_body', 'Lora') == $font)>
                                                        {{ $font }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                     <x-input-error :messages="$errors->get('font_family_body')" class="mt-2" />
                                </div>

                                {{-- Photo Shape --}}
                                <div>
                                    <x-input-label for="photo_shape" value="Photo Shape" />
                                    <select id="photo_shape" name="photo_shape" data-preview-target="photo-preview" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach ($photoShapes as $shape)
                                            <option value="{{ $shape['value'] }}" @selected(old('photo_shape', 'rounded-full') == $shape['value'])>{{ $shape['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('photo_shape')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="flex items-center justify-end p-6 bg-gray-50 border-t border-gray-200">
                        <a href="{{ isset($userFor) ? route('admin.users.edit', $userFor) : route('dashboard') }}" class="text-sm">
                            Cancel
                        </a>
                        <x-primary-button class="ml-4">
                            {{ __('Create Memorial') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const photoShapeSelect = document.querySelector('select[data-preview-target="photo-preview"]');
                if (photoShapeSelect) {
                    const previewImage = document.getElementById(photoShapeSelect.dataset.previewTarget);
                    const allShapeClasses = ['rounded-full', 'rounded-2xl', '', 'shape-diamond', 'shape-octagon', 'shape-heart', 'shape-cross'];

                    photoShapeSelect.addEventListener('change', function () {
                        if (previewImage) {
                            allShapeClasses.forEach(cls => {
                                if (cls) {
                                    previewImage.classList.remove(cls);
                                }
                            });
                            if (this.value) {
                                previewImage.classList.add(this.value);
                            }
                        }
                    });
                }
                
                const quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                const form = document.querySelector('#memorial-form');
                const hiddenInput = document.querySelector('input[name=biography]');

                form.addEventListener('submit', function() {
                    const editorContent = quill.root.innerHTML;
                    if (editorContent === '<p><br></p>') {
                        hiddenInput.value = '';
                    } else {
                        hiddenInput.value = editorContent;
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>