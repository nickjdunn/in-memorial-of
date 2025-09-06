<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Edit User') }}: <span style="color: var(--color-primary-400)">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12 main-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Edit User Details Form --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold font-heading">
                        User Information
                    </h3>
                     <p class="mt-1 text-sm text-gray-600">
                        Update the user's account information and administrative status.
                    </p>
                </div>
                <form method="post" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('put')
                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="memorial_slots_purchased" value="Memorial Slots Purchased" />
                            <x-text-input id="memorial_slots_purchased" name="memorial_slots_purchased" type="number" class="mt-1 block w-full" :value="old('memorial_slots_purchased', $user->memorial_slots_purchased)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('memorial_slots_purchased')" />
                        </div>

                        <div class="block mt-4">
                            <label for="is_admin" class="inline-flex items-center">
                                <input id="is_admin" type="checkbox" class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin))>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Administrator') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-6 bg-gray-50 border-t border-gray-200">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- User's Memorials List --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                 <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold font-heading">Memorials Created by this User</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deceased Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($memorials as $memorial)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $memorial->full_name }}</td>
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
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">This user has not created any memorials.</td>
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

            {{-- Delete User Form --}}
             <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-red-600 font-heading">
                        {{ __('Delete User') }}
                    </h3>
                     <p class="mt-1 text-sm text-gray-600">
                        Once this account is deleted, all of its resources and data, including any memorial pages, will be permanently deleted.
                    </p>
                </div>
                <div class="p-6">
                    <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to permanently delete this user and all of their memorials?');">
                        @csrf
                        @method('delete')
                        <x-danger-button>
                            {{ __('Delete User Account') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>