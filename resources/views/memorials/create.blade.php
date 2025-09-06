<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Create Memorial Page') }}
        </h2>
    </x-slot>
    <div class="py-12 main-content">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('memorials.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 md:p-8 space-y-6">
                        <div>
                            <x-input-label for="full_name" value="Full Name of the Deceased" />
                            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus />
                            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="date_of_birth" value="Date of Birth" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date_of_passing" value="Date of Passing" />
                                <x-text-input id="date_of_passing" class="block mt-1 w-full" type="date" name="date_of_passing" :value="old('date_of_passing')" required />
                                <x-input-error :messages="$errors->get('date_of_passing')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="biography" value="Biography / Life Story" />
                            <textarea id="biography" name="biography" rows="8" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('biography') }}</textarea>
                            <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="profile_photo" value="Profile Photo" />
                            <input id="profile_photo" name="profile_photo" type="file" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-6 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
</x-app-layout>