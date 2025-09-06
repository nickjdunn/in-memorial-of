<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 main-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-gray-50 border-b border-gray-200 md:flex md:items-center md:justify-between">
                    <h3 class="text-xl font-bold font-heading">Your Memorial Slots</h3>
                    <div class="mt-4 md:mt-0 flex items-center space-x-2">
                        {{-- The Admin Area link has been removed from here --}}
                        <a href="{{ route('purchase.show') }}" class="button-link inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-500">
                            Purchase Another Slot
                        </a>
                        @if (auth()->user()->memorials->count() < auth()->user()->memorial_slots_purchased)
                            <a href="{{ route('memorials.create') }}" class="button-link inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                Create New Memorial
                            </a>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                     <p class="text-gray-600">
                        You have purchased <span class="font-semibold">{{ auth()->user()->memorial_slots_purchased }}</span> slot(s) and have used <span class="font-semibold">{{ auth()->user()->memorials->count() }}</span>.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold font-heading">Your Memorial Pages</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Public Link</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse (auth()->user()->memorials as $memorial)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{ $memorial->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a href="{{ route('memorials.show_public', $memorial->slug) }}" target="_blank">
                                                {{ route('memorials.show_public', $memorial->slug) }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                            <a href="{{ route('memorials.edit', $memorial) }}">Edit</a>
                                            <form method="POST" action="{{ route('memorials.destroy', $memorial) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete this memorial page? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            You have not created any memorial pages yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>