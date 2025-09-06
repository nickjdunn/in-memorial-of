<div class="w-full bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex h-12">
            <!-- Navigation Links -->
            <div class="flex space-x-8">
                <x-nav-link-sub :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Users') }}
                </x-nav-link-sub>

                <x-nav-link-sub :href="route('admin.memorials.index')" :active="request()->routeIs('admin.memorials.*')">
                    {{ __('Memorials') }}
                </x-nav-link-sub>

                <x-nav-link-sub :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    {{ __('Site Settings') }}
                </x-nav-link-sub>
            </div>
        </div>
    </div>
</div>