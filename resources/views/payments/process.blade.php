<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Processing Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <!-- Simulated Payment Gateway -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ $payment->payment_method == 'gcash' ? 'GCash' : 'PayMaya' }} Payment Gateway
                        </h3>
                        
                        <div class="mt-6 mb-8 w-24 mx-auto">
                            <img src="{{ asset($payment->payment_method == 'gcash' ? 'images/gcash-logo.png' : 'images/paymaya-logo.png') }}" 
                                alt="{{ $payment->payment_method == 'gcash' ? 'GCash' : 'PayMaya' }}" 
                                class="w-full">
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg border max-w-md mx-auto mb-6">
                            <div class="mb-4">
                                <p class="text-gray-700">Amount Due:</p>
                                <p class="text-xl font-bold">₱{{ number_format($payment->amount, 2) }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-gray-700">Reference Number:</p>
                                <p class="font-medium">{{ $payment->reference_number }}</p>
                            </div>
                        </div>
                        
                        <!-- Simulated Payment Form -->
                        <form action="{{ route('payments.callback') }}" method="GET" class="max-w-md mx-auto">
                            <input type="hidden" name="reference" value="{{ $payment->reference_number }}">
                            
                            @if($payment->payment_method == 'gcash')
                                <div class="mb-4">
                                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1 text-left">GCash Mobile Number</label>
                                    <input type="text" id="mobile" name="mobile" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="09XX XXX XXXX" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-1 text-left">MPIN</label>
                                    <input type="password" id="pin" name="pin" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter 4-digit MPIN" maxlength="4" required>
                                </div>
                            @else
                                <div class="mb-4">
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1 text-left">Card Number</label>
                                    <input type="text" id="card_number" name="card_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="XXXX XXXX XXXX XXXX" required>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="expiry" class="block text-sm font-medium text-gray-700 mb-1 text-left">Expiry Date</label>
                                        <input type="text" id="expiry" name="expiry" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="MM/YY" required>
                                    </div>
                                    
                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1 text-left">CVV</label>
                                        <input type="password" id="cvv" name="cvv" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="XXX" maxlength="3" required>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="bg-yellow-50 border border-yellow-100 p-3 mb-6 text-left text-sm text-yellow-800 rounded-md">
                                This is a simulation for demonstration purposes. No actual payment will be processed.
                            </div>
                            
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Complete Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>