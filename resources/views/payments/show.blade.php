<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <div class="max-w-2xl mx-auto">
                        <!-- Payment Header -->
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">Complete Your Payment</h1>
                            <p class="text-gray-600">Please select your preferred payment method to continue</p>
                        </div>
                        
                        <!-- Payment Details -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-600">Service:</span>
                                <span class="font-medium text-gray-900">{{ $request->service->name }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-600">Request ID:</span>
                                <span class="font-medium text-gray-900">{{ $request->tracking_number }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium text-gray-900">{{ now()->format('F d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xl">
                                <span class="font-medium text-gray-900">Total Amount:</span>
                                <span class="font-bold text-blue-600">₱{{ number_format($request->service->fee, 2) }}</span>
                            </div>
                        </div>

                        <!-- Payment Methods Form -->
                        <form action="{{ route('payments.process', $request) }}" method="POST">
                            @csrf
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-base font-medium text-gray-900">Select Payment Method</label>
                                    <p class="text-sm text-gray-500">Choose how you'd like to pay</p>
                                    
                                    <div class="mt-4 space-y-3">
                                        <div class="relative border border-gray-200 rounded-lg px-5 py-4 hover:border-gray-300 cursor-pointer">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="payment_method" value="gcash" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                                <div class="ml-3">
                                                    <span class="block text-sm font-medium text-gray-900">GCash</span>
                                                    <span class="block text-xs text-gray-500">Pay using your GCash account</span>
                                                </div>
                                                <img src="{{ asset('images/gcash-logo.png') }}" alt="GCash" class="h-8 ml-auto">
                                            </label>
                                        </div>
                                        
                                        <div class="relative border border-gray-200 rounded-lg px-5 py-4 hover:border-gray-300 cursor-pointer">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="payment_method" value="paymaya" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <div class="ml-3">
                                                    <span class="block text-sm font-medium text-gray-900">PayMaya</span>
                                                    <span class="block text-xs text-gray-500">Pay using your PayMaya account</span>
                                                </div>
                                                <img src="{{ asset('images/paymaya-logo.png') }}" alt="PayMaya" class="h-8 ml-auto">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                    <a href="{{ route('requests.show', $request) }}" class="inline-flex justify-center py-3 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        Cancel
                                    </a>
                                    <button type="submit" class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex-1 sm:flex-none">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Proceed to Payment
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Secure Payment Notice -->
                        <div class="mt-8 flex items-center justify-center text-sm text-gray-500">
                            <svg class="h-5 w-5 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Secured by PayMongo. Your payment information is encrypted.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>