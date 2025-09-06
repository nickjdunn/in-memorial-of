<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 main-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                 <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold font-heading">All Memorials</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deceased Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owned By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($memorials as $memorial)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $memorial->full_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{-- UPDATED: Make the owner's name a link to their edit page --}}
                                            <a href="{{ route('admin.users.edit', $memorial->user) }}" class="hover:underline">
                                                {{ $memorial->user->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memorial->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                            <a href="{{ route('memorials.show_public', $memorial->slug) }}" target="_blank">View</a>
                                            <a href="{{ route('admin.memorials.edit', $memorial) }}">Edit</a>
                                            <form class="inline-block" method="POST" action="{{ route('admin.memorials.destroy', $memorial) }}" onsubmit="return confirm('Are you sure you want to delete the memorial for {{ addslashes($memorial->full_name) }}? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No memorials found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $memorials->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>