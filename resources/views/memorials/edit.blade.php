<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Edit Memorial Page') }}
        </h2>
    </x-slot>

    <div class="py-12 main-content">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('memorials.update', $memorial) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6 md:p-8 space-y-6">
                        
                        {{-- Memorial Information Section --}}
                        <div>
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Memorial Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="full_name" value="Full Name of the Deceased" />
                                    <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name', $memorial->full_name)" required autofocus />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="date_of_birth" value="Date of Birth" />
                                        <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth', $memorial->date_of_birth)" required />
                                    </div>
                                    <div>
                                        <x-input-label for="date_of_passing" value="Date of Passing" />
                                        <x-text-input id="date_of_passing" class="block mt-1 w-full" type="date" name="date_of_passing" :value="old('date_of_passing', $memorial->date_of_passing)" required />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="biography" value="Biography / Life Story" />
                                    <textarea id="biography" name="biography" rows="8" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('biography', $memorial->biography) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Profile Photo Section --}}
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Profile Photo</h3>
                            <div class="flex items-center space-x-6">
                                @if ($memorial->profile_photo_path)
                                    <img src="{{ asset('storage/' . $memorial->profile_photo_path) }}" alt="{{ $memorial->full_name }}" class="h-24 w-24 rounded-full object-cover">
                                @else
                                    <span class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                        <svg class="h-16 w-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </span>
                                @endif
                                <div>
                                    <x-input-label for="profile_photo" value="Upload a new photo (optional)" />
                                    <input id="profile_photo" name="profile_photo" type="file" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                </div>
                            </div>
                        </div>

                        {{-- Theme Customization Section --}}
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Page Theme & Appearance</h3>
                            <div class="space-y-6">
                                @php
                                    $fonts = ['Playfair Display', 'Lora', 'Merriweather', 'Source Serif 4', 'Figtree', 'Roboto', 'Lato', 'Montserrat', 'Inter', 'Open Sans'];
                                    sort($fonts);
                                    $photoShapes = [
                                        ['value' => 'rounded-full', 'label' => 'Circle'],
                                        ['value' => 'rounded-2xl', 'label' => 'Rounded Square'],
                                        ['value' => '', 'label' => 'Square (no rounding)'],
                                    ];
                                @endphp

                                {{-- Primary Color --}}
                                <div>
                                    <x-input-label for="primary_color" value="Accent Color" />
                                    <div class="mt-1 flex items-center space-x-3">
                                        <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $memorial->primary_color) }}" class="h-10 w-10 p-1 border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                                    </div>
                                </div>

                                {{-- Name Font --}}
                                <div>
                                    <x-input-label for="font_family_name" value="Name & Title Font" />
                                    <select id="font_family_name" name="font_family_name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach ($fonts as $font)
                                            <option value="{{ $font }}" @selected(old('font_family_name', $memorial->font_family_name) == $font)>{{ $font }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('font_family_name')" class="mt-2" />
                                </div>

                                {{-- Body Font --}}
                                <div>
                                    <x-input-label for="font_family_body" value="Biography Font" />
                                    <select id="font_family_body" name="font_family_body" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach ($fonts as $font)
                                            <option value="{{ $font }}" @selected(old('font_family_body', $memorial->font_family_body) == $font)>{{ $font }}</option>
                                        @endforeach
                                    </select>
                                     <x-input-error :messages="$errors->get('font_family_body')" class="mt-2" />
                                </div>

                                {{-- Photo Shape --}}
                                <div>
                                    <x-input-label for="photo_shape" value="Photo Shape" />
                                    <select id="photo_shape" name="photo_shape" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach ($photoShapes as $shape)
                                            <option value="{{ $shape['value'] }}" @selected(old('photo_shape', $memorial->photo_shape) == $shape['value'])>{{ $shape['label'] }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('photo_shape')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="flex items-center justify-end p-6 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" class="text-sm">
                            Cancel
                        </a>
                        <x-primary-button class="ml-4">
                            {{ __('Save Changes') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>