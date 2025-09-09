<x-app-layout>
    @push('head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya&family=Asap&family=Bitter&family=Cabin&family=Caveat&family=Cormorant+Garamond&family=Crimson+Text&family=Dancing+Script&family=Domine&family=EB+Garamond&family=Figtree&family=Inter&family=Kalam&family=Lato&family=Libre+Baskerville&family=Lora&family=Merriweather&family=Montserrat&family=Mulish&family=Nunito&family=Open+Sans&family=Patrick+Hand&family=Playfair+Display&family=Poppins&family=PT+Serif&family=Raleway&family=Roboto&family=Source+Serif+4&family=Work+Sans&display=swap" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Edit Memorial Page') }}
        </h2>
    </x-slot>

    <div class="py-12 main-content" x-data="{ activeTab: 'details' }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

             <!-- Tab Navigation -->
            <div class="mb-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'details'"
                            :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'details', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'details' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Memorial Details
                    </button>
                    <button @click="activeTab = 'tributes'"
                            :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'tributes', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tributes' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Tribute Moderation
                        @if($pendingTributes->count() > 0)
                            <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $pendingTributes->count() }}</span>
                        @endif
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <!-- Memorial Details Tab -->
                <div x-show="activeTab === 'details'" x-cloak>
                    <form id="memorial-form" method="POST" action="{{ route('memorials.update', $memorial) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if(request()->has('from_user'))
                            <input type="hidden" name="redirect_to_user" value="{{ request()->get('from_user') }}">
                        @endif

                        <div class="p-6 md:p-8 space-y-6">
                            {{-- Memorial Information Section --}}
                            <div>
                                <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Memorial Information</h3>
                                <div class="space-y-6">
                                    <div>
                                        <x-input-label for="full_name" value="Full Name" />
                                        <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name', $memorial->full_name)" required autofocus />
                                        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                                    </div>
                                    @php
                                        $birthDate = $memorial->date_of_birth ? \Carbon\Carbon::parse($memorial->date_of_birth) : null;
                                        $passingDate = $memorial->date_of_passing ? \Carbon\Carbon::parse($memorial->date_of_passing) : null;
                                    @endphp
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <x-input-label value="Beginning Date (Optional)" />
                                            <div class="flex space-x-2 mt-1">
                                                <select name="birth_month" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Month</option>
                                                    @foreach(range(1, 12) as $month)
                                                        <option value="{{ $month }}" @selected(old('birth_month', $birthDate?->month) == $month)>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="birth_day" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Day</option>
                                                    @foreach(range(1, 31) as $day)
                                                        <option value="{{ $day }}" @selected(old('birth_day', $birthDate?->day) == $day)>{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="birth_year" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Year</option>
                                                    @foreach(range(date('Y'), 1800) as $year)
                                                        <option value="{{ $year }}" @selected(old('birth_year', $birthDate?->year) == $year)>{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label value="Ending Date (Optional)" />
                                            <div class="flex space-x-2 mt-1">
                                                <select name="passing_month" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Month</option>
                                                    @foreach(range(1, 12) as $month)
                                                        <option value="{{ $month }}" @selected(old('passing_month', $passingDate?->month) == $month)>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="passing_day" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Day</option>
                                                    @foreach(range(1, 31) as $day)
                                                        <option value="{{ $day }}" @selected(old('passing_day', $passingDate?->day) == $day)>{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="passing_year" class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Year</option>
                                                    @foreach(range(date('Y'), 1800) as $year)
                                                        <option value="{{ $year }}" @selected(old('passing_year', $passingDate?->year) == $year)>{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-input-error :messages="$errors->get('date_of_passing')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div>
                                        <x-input-label for="biography" value="Biography / Life Story" />
                                        <input name="biography" type="hidden">
                                        <div id="editor-container" class="mt-1">
                                            {!! old('biography', $memorial->biography) !!}
                                        </div>
                                        <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            {{-- Profile Photo Section --}}
                            <div class="pt-6 border-t">
                                <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Profile Photo</h3>
                                <div class="flex items-center space-x-6">
                                    <img id="photo-preview" src="{{ $memorial->profile_photo_path ? asset('storage/' . $memorial->profile_photo_path) : 'https://via.placeholder.com/96/f3f4f6/cbd5e1?text=Photo' }}" alt="Profile photo preview" class="h-24 w-24 object-cover transition-all duration-300 ease-in-out {{ $memorial->photo_shape }}">
                                    <div>
                                        <x-input-label for="profile_photo" value="Upload a new photo (optional)" />
                                        <input id="profile_photo" name="profile_photo" type="file" accept="image/*" onchange="document.getElementById('photo-preview').src = window.URL.createObjectURL(this.files[0])" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                        <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            {{-- Theme Customization Section --}}
                            <div class="pt-6 border-t">
                                <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Page Theme & Appearance</h3>
                                <div class="space-y-6">
                                    @php
                                        $photoShapes = [['value' => 'rounded-full', 'label' => 'Circle'], ['value' => 'rounded-2xl', 'label' => 'Rounded Square'], ['value' => '', 'label' => 'Square'], ['value' => 'shape-diamond', 'label' => 'Diamond'], ['value' => 'shape-octagon', 'label' => 'Octagon'], ['value' => 'shape-heart', 'label' => 'Heart'], ['value' => 'shape-cross', 'label' => 'Cross']];
                                    @endphp
                                    <div>
                                        <x-input-label for="primary_color" value="Accent Color" />
                                        <div class="mt-1 flex items-center space-x-3">
                                            <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $memorial->primary_color) }}" class="h-10 w-10 p-1 border-gray-300 rounded-md">
                                            <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div>
                                        <x-input-label for="font_family_name" value="Name & Title Font" />
                                        <select id="font_family_name" name="font_family_name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach (config('fonts.options') as $group => $fonts)
                                                <optgroup label="{{ $group }}">
                                                    @foreach ($fonts as $font)
                                                        <option value="{{ $font }}" style="font-family: '{{ $font }}', sans-serif; font-size: 1.1rem;" @selected(old('font_family_name', $memorial->font_family_name) == $font)>{{ $font }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('font_family_name')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="font_family_body" value="Biography Font" />
                                        <select id="font_family_body" name="font_family_body" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach (config('fonts.options') as $group => $fonts)
                                                <optgroup label="{{ $group }}">
                                                    @foreach ($fonts as $font)
                                                        <option value="{{ $font }}" style="font-family: '{{ $font }}', sans-serif; font-size: 1.1rem;" @selected(old('font_family_body', $memorial->font_family_body) == $font)>{{ $font }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('font_family_body')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="photo_shape" value="Photo Shape" />
                                        <select id="photo_shape" name="photo_shape" data-preview-target="photo-preview" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach ($photoShapes as $shape)
                                                <option value="{{ $shape['value'] }}" @selected(old('photo_shape', $memorial->photo_shape) == $shape['value'])>{{ $shape['label'] }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('photo_shape')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <!-- Page Features Section -->
                            <div class="pt-6 border-t" x-data="{ visibility: '{{ old('visibility', $memorial->visibility) }}' }">
                                <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Page Features</h3>
                                <div class="space-y-6">
                                    <!-- Enable Tributes Toggle -->
                                    <div class="relative flex items-start">
                                        <div class="flex h-6 items-center">
                                            <input id="tributes_enabled" name="tributes_enabled" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" @checked(old('tributes_enabled', $memorial->tributes_enabled))>
                                        </div>
                                        <div class="ml-3 text-sm leading-6">
                                            <label for="tributes_enabled" class="font-medium text-gray-900">Enable Tributes</label>
                                            <p class="text-gray-500">Allow visitors to leave tributes on the memorial page.</p>
                                        </div>
                                    </div>
                                    <!-- Privacy Settings -->
                                    <fieldset>
                                        <legend class="text-sm font-medium leading-6 text-gray-900">Privacy</legend>
                                        <p class="text-sm text-gray-500">Choose who can see this memorial page.</p>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center">
                                                <input x-model="visibility" id="visibility-public" name="visibility" type="radio" value="public" @checked(old('visibility', $memorial->visibility) == 'public') class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                <label for="visibility-public" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Public (Only those with the link can see it)</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input x-model="visibility" id="visibility-private" name="visibility" type="radio" value="private" @checked(old('visibility', $memorial->visibility) == 'private') class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                <label for="visibility-private" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Private (Password Protected)</label>
                                            </div>
                                        </div>
                                        <div x-show="visibility === 'private'" x-transition class="mt-4" x-data="{ show: false }">
                                            <x-input-label for="password" value="Set or Update Password" />
                                            <div class="relative mt-1">
                                                <!-- THIS IS THE CORRECTED PART: Using a plain HTML input tag -->
                                                <input id="password" name="password" 
                                                       :type="show ? 'text' : 'password'"
                                                       placeholder="Leave blank to keep current password"
                                                       class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                                    <svg @click="show = !show" x-show="!show" class="h-5 w-5 text-gray-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                    <svg @click="show = !show" x-show="show" x-cloak class="h-5 w-5 text-gray-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064 7-9.542 7 1.356 0 2.64 .316 3.825 .875M17.5 17.5l-2.086-2.086M9 9l-2.086-2.086m0 0A9.986 9.986 0 0112 5c.83 0 1.633 .11 2.38 .315" /></svg>
                                                </div>
                                            </div>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        <x-input-error :messages="$errors->get('visibility')" class="mt-2" />
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end p-6 bg-gray-50 border-t border-gray-200">
                            <a href="{{ request()->has('from_user') ? route('admin.users.edit', request()->get('from_user')) : route('dashboard') }}" class="text-sm">Cancel</a>
                            <x-primary-button class="ml-4">{{ __('Save Changes') }}</x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Tribute Moderation Tab -->
                <div x-show="activeTab === 'tributes'" x-cloak>
                    <div class="p-6 md:p-8">
                        <!-- Pending Tributes Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Pending Tributes</h3>
                            <div class="space-y-4">
                                @forelse ($pendingTributes as $tribute)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p><strong class="font-semibold">{{ $tribute->name }}</strong><span class="text-gray-500 text-sm ml-2">{{ $tribute->created_at->format('M j, Y, g:i a') }}</span></p>
                                                <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $tribute->message }}</p>
                                            </div>
                                            <div class="flex space-x-2 flex-shrink-0 ml-4">
                                                <form action="{{ route('tributes.approve', $tribute) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm font-medium">Approve</button></form>
                                                <form action="{{ route('tributes.destroy', $tribute) }}" method="POST" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm font-medium">Delete</button></form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No pending tributes.</p>
                                @endforelse
                            </div>
                        </div>
                        <!-- Approved Tributes Section -->
                        <div>
                            <h3 class="text-lg font-medium leading-6 font-heading border-b pb-2 mb-4">Approved Tributes</h3>
                            <div class="space-y-4">
                                @forelse ($approvedTributes as $tribute)
                                    <div class="border rounded-lg p-4 bg-gray-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p><strong class="font-semibold">{{ $tribute->name }}</strong><span class="text-gray-500 text-sm ml-2">{{ $tribute->created_at->format('M j, Y, g:i a') }}</span></p>
                                                <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $tribute->message }}</p>
                                            </div>
                                            <div class="flex space-x-2 flex-shrink-0 ml-4">
                                                <form action="{{ route('tributes.destroy', $tribute) }}" method="POST" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="px-3 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 text-sm font-medium">Delete</button></form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No approved tributes.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
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
                            allShapeClasses.forEach(cls => { if (cls) { previewImage.classList.remove(cls); } });
                            if (this.value) { previewImage.classList.add(this.value); }
                        }
                    });
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
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