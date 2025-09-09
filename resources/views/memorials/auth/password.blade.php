<x-memorial-layout :memorial="$memorial">
    <x-slot name="title">Password Required</x-slot>

    <div class="min-h-screen py-8 sm:py-12 px-4 flex items-center justify-center">
        <div class="w-full max-w-md mx-auto p-6 md:p-8 bg-white shadow-2xl overflow-hidden sm:rounded-lg"
             style="border-top: 8px solid {{ $memorial->primary_color }};">
            
            <div class="text-center">
                <h1 class="text-xl sm:text-2xl font-bold" 
                    style="color: {{ $memorial->primary_color }}; font-family: '{{ $memorial->font_family_name }}', serif;">
                    This memorial is private
                </h1>
                <p class="mt-2 text-gray-600">Please enter the password to view the memorial for <br><strong>{{ $memorial->full_name }}</strong>.</p>
            </div>

            <form method="POST" action="{{ route('memorials.password.check', $memorial->slug) }}" class="mt-8 space-y-6">
                @csrf
                
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                           placeholder="Password">
                    
                    @if(session('error'))
                        <p class="mt-2 text-sm text-red-600">{{ session('error') }}</p>
                    @endif
                </div>

                <div>
                    <button type="submit" 
                            class="group relative flex w-full justify-center rounded-md border border-transparent py-2 px-4 text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2"
                            style="background-color: {{ $memorial->primary_color }};">
                        Unlock Memorial
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-memorial-layout>