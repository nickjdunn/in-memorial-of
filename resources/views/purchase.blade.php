<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl page-title font-heading">
            {{ __('Complete Your Purchase') }}
        </h2>
    </x-slot>

    <div class="py-12 main-content">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 md:p-8 text-center">
                    <h2 class="text-2xl font-bold font-heading">Confirm Your Purchase</h2>
                    <p class="text-gray-600 mt-2">You are about to purchase one "Permanent Memorial Page" slot for a one-time fee of ${{ config('app_settings.site_price') }}.</p>
                    <p class="text-gray-500 text-sm mt-1">You will be redirected to our secure payment partner, Stripe, to complete your purchase.</p>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <form action="{{ route('purchase.process') }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-center">
                            <x-primary-button>
                                Proceed to Secure Payment
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>