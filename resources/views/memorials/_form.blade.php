<div class="space-y-6">
    <!-- Full Name -->
    <div>
        <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $memorial->full_name ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Dates -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', isset($memorial->date_of_birth) ? \Carbon\Carbon::parse($memorial->date_of_birth)->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('date_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="date_of_passing" class="block text-sm font-medium text-gray-700">Date of Passing</label>
            <input type="date" name="date_of_passing" id="date_of_passing" value="{{ old('date_of_passing', isset($memorial->date_of_passing) ? \Carbon\Carbon::parse($memorial->date_of_passing)->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('date_of_passing') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- Biography -->
    <div>
        <label for="biography" class="block text-sm font-medium text-gray-700">Biography</label>
        <div id="editor-container" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm h-60"></div>
        <input type="hidden" name="biography" id="biography" value="{{ old('biography', $memorial->biography ?? '') }}">
        @error('biography') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Profile Photo -->
    <div>
        <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
        <input type="file" name="profile_photo" id="profile_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        @if(isset($memorial) && $memorial->profile_photo_path)
        <div class="mt-4">
            <p class="text-sm text-gray-500">Current Photo:</p>
            <img src="{{ asset('storage/' . $memorial->profile_photo_path) }}" alt="Current profile photo" class="mt-2 h-24 w-24 rounded-md object-cover">
        </div>
        @endif
        @error('profile_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Customization Options -->
    <div class="pt-6 border-t">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Customization</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Primary Color -->
            <div>
                <label for="primary_color" class="block text-sm font-medium text-gray-700">Theme Color</label>
                <input type="color" name="primary_color" id="primary_color" value="{{ old('primary_color', $memorial->primary_color ?? '#8B5CF6') }}" class="mt-1 block w-full h-10 border-gray-300 rounded-md shadow-sm">
                @error('primary_color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Photo Shape -->
            <div>
                <label for="photo_shape" class="block text-sm font-medium text-gray-700">Photo Shape</label>
                <select name="photo_shape" id="photo_shape" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="rounded-none" {{ (old('photo_shape', $memorial->photo_shape ?? '') == 'rounded-none') ? 'selected' : '' }}>Square</option>
                    <option value="rounded-md" {{ (old('photo_shape', $memorial->photo_shape ?? '') == 'rounded-md') ? 'selected' : '' }}>Rounded</option>
                    <option value="rounded-lg" {{ (old('photo_shape', $memorial->photo_shape ?? '') == 'rounded-lg') ? 'selected' : '' }}>Very Rounded</option>
                    <option value="rounded-full" {{ (old('photo_shape', $memorial->photo_shape ?? 'rounded-full') == 'rounded-full') ? 'selected' : '' }}>Circle</option>
                </select>
                @error('photo_shape') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Font Family Name -->
            <div>
                <label for="font_family_name" class="block text-sm font-medium text-gray-700">Heading Font</label>
                <input type="text" name="font_family_name" id="font_family_name" value="{{ old('font_family_name', $memorial->font_family_name ?? 'Playfair Display') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('font_family_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Font Family Body -->
            <div>
                <label for="font_family_body" class="block text-sm font-medium text-gray-700">Body Font</label>
                <input type="text" name="font_family_body" id="font_family_body" value="{{ old('font_family_body', $memorial->font_family_body ?? 'Lato') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('font_family_body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <!-- NEW: Enable Tributes Toggle -->
    <div class="pt-6 border-t">
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="tributes_enabled" name="tributes_enabled" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" 
                {{ old('tributes_enabled', $memorial->tributes_enabled ?? true) ? 'checked' : '' }}>
            </div>
            <div class="ml-3 text-sm">
                <label for="tributes_enabled" class="font-medium text-gray-700">Enable Tributes</label>
                <p class="text-gray-500">Allow visitors to leave tributes on the memorial page.</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 pt-5">
    <div class="flex justify-end">
        <a href="{{ route('dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Cancel
        </a>
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save
        </button>
    </div>
</div>