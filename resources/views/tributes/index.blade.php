<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tribute Moderation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Pending Tributes Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Pending Tributes</h3>
                    <div class="space-y-6">
                        @forelse ($pendingTributes as $tribute)
                            <div class="border rounded-lg p-4 shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            For Memorial: <a href="{{ route('memorials.show_public', $tribute->memorial->slug) }}" class="text-blue-600 hover:underline" target="_blank">{{ $tribute->memorial->full_name }}</a>
                                        </p>
                                        <p class="mt-2">
                                            <strong class="font-semibold">{{ $tribute->name }}</strong>
                                            <span class="text-gray-500 text-sm ml-2">{{ $tribute->created_at->format('M j, Y, g:i a') }}</span>
                                        </p>
                                        <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $tribute->message }}</p>
                                    </div>
                                    <div class="flex space-x-2 flex-shrink-0 ml-4">
                                        <form action="{{ route('tributes.approve', $tribute) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm font-medium">Approve</button>
                                        </form>
                                        <form action="{{ route('tributes.destroy', $tribute) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tribute?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-dashed border-2 border-gray-300 rounded-lg p-8 text-center">
                                <p class="text-gray-500">There are no pending tributes to review at this time.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Approved Tributes Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Approved Tributes</h3>
                    <div class="space-y-6">
                        @forelse ($approvedTributes as $tribute)
                            <div class="border rounded-lg p-4 shadow-sm bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            For Memorial: <a href="{{ route('memorials.show_public', $tribute->memorial->slug) }}" class="text-blue-600 hover:underline" target="_blank">{{ $tribute->memorial->full_name }}</a>
                                        </p>
                                        <p class="mt-2">
                                            <strong class="font-semibold">{{ $tribute->name }}</strong>
                                            <span class="text-gray-500 text-sm ml-2">{{ $tribute->created_at->format('M j, Y, g:i a') }}</span>
                                        </p>
                                        <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $tribute->message }}</p>
                                    </div>
                                    <div class="flex space-x-2 flex-shrink-0 ml-4">
                                        <form action="{{ route('tributes.destroy', $tribute) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this tribute?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500">There are no approved tributes yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>