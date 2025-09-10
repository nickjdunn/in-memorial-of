<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @include('admin.partials.tabs')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <h3 class="text-2xl font-bold mb-4">Site Settings</h3>
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="space-y-6 max-w-lg">
                            <div>
                                <label for="homepage_example_memorial_id" class="block text-sm font-medium text-gray-700">Homepage Example Memorial</label>
                                <select id="homepage_example_memorial_id" name="homepage_example_memorial_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">None</option>
                                    @foreach($memorials as $memorial)
                                        <option value="{{ $memorial->id }}" @selected(old('homepage_example_memorial_id', $settings['homepage_example_memorial_id'] ?? '') == $memorial->id)>
                                            {{ $memorial->full_name }} (by {{ $memorial->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-sm text-gray-500">Select which memorial page to feature on the homepage as a live theme example.</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>