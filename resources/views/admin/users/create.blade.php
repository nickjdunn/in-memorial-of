<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="py-12 main-content">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold font-heading">
                        New User Details
                    </h3>
                     <p class="mt-1 text-sm text-gray-600">
                        Create a new account. The user will be able to log in with the password you set.
                    </p>
                </div>
                <form method="post" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="memorial_slots_purchased" value="Memorial Slots Purchased" />
                            <x-text-input id="memorial_slots_purchased" name="memorial_slots_purchased" type="number" class="mt-1 block w-full" :value="old('memorial_slots_purchased', 0)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('memorial_slots_purchased')" />
                        </div>

                        <div class="block mt-4">
                            <label for="is_admin" class="inline-flex items-center">
                                <input id="is_admin" type="checkbox" class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500" name="is_admin" value="1" @checked(old('is_admin'))>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Make Administrator') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-6 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}" class="text-sm">Cancel</a>
                        <x-primary-button>{{ __('Create User') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>