@extends('layouts.app')

@section('title', 'Checkout - Complete Your Booking')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <i class="fas fa-lock text-5xl mb-4 opacity-90"></i>
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Secure Checkout</h1>
            <p class="text-xl opacity-90">Complete your booking payment securely</p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <i class="fas fa-credit-card text-blue-600"></i>
                        Payment Information
                    </h2>

                    <form action="{{ route('bookings.payment', $booking->id) }}" method="POST" id="paymentForm">
                        @csrf

                        <!-- Payment Type -->
                        <div class="mb-8">
                            <label class="block text-lg font-semibold text-gray-700 mb-4">
                                <i class="fas fa-hand-holding-usd text-green-600"></i> Payment Option
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="payment_full" name="payment_type" value="full" class="peer hidden" checked>
                                    <label for="payment_full" class="flex flex-col p-6 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-lg text-gray-800">Pay Full Amount</span>
                                            <i class="fas fa-check-circle text-2xl text-blue-600 opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                        <span class="text-3xl font-bold text-blue-600">${{ number_format($booking->total_amount, 2) }}</span>
                                        <span class="text-sm text-gray-600 mt-2">Complete payment now</span>
                                        <div class="mt-3 inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-tag"></i> Best Value
                                        </div>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" id="payment_deposit" name="payment_type" value="deposit" class="peer hidden">
                                    <label for="payment_deposit" class="flex flex-col p-6 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-lg text-gray-800">Pay Deposit</span>
                                            <i class="fas fa-check-circle text-2xl text-blue-600 opacity-0"></i>
                                        </div>
                                        <span class="text-3xl font-bold text-blue-600">${{ number_format($booking->total_amount * 0.3, 2) }}</span>
                                        <span class="text-sm text-gray-600 mt-2">30% deposit (Pay remaining later)</span>
                                        <div class="mt-3 text-xs text-gray-500">
                                            Remaining: ${{ number_format($booking->total_amount * 0.7, 2) }}
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-8">
                            <label class="block text-lg font-semibold text-gray-700 mb-4">
                                <i class="fas fa-wallet text-purple-600"></i> Payment Method
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="relative">
                                    <input type="radio" id="credit_card" name="payment_method" value="credit_card" class="peer hidden" checked>
                                    <label for="credit_card" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <i class="fas fa-credit-card text-4xl text-blue-600 mb-2"></i>
                                        <span class="font-semibold text-sm text-center">Credit Card</span>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" id="paypal" name="payment_method" value="paypal" class="peer hidden">
                                    <label for="paypal" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <i class="fab fa-paypal text-4xl text-blue-500 mb-2"></i>
                                        <span class="font-semibold text-sm text-center">PayPal</span>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="peer hidden">
                                    <label for="bank_transfer" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <i class="fas fa-university text-4xl text-green-600 mb-2"></i>
                                        <span class="font-semibold text-sm text-center">Bank Transfer</span>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" id="cash" name="payment_method" value="cash" class="peer hidden">
                                    <label for="cash" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <i class="fas fa-money-bill-wave text-4xl text-green-700 mb-2"></i>
                                        <span class="font-semibold text-sm text-center">Cash</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Credit Card Details (shown only when credit card selected) -->
                        <div id="creditCardDetails" class="mb-8 border-t pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Card Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <div class="relative">
                                        <input type="text" placeholder="1234 5678 9012 3456" maxlength="19"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-12 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               id="card_number">
                                        <i class="fas fa-credit-card absolute left-4 top-4 text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" placeholder="MM/YY" maxlength="5"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               id="card_expiry">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                        <input type="text" placeholder="123" maxlength="3"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               id="card_cvv">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                                    <input type="text" placeholder="John Doe"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           id="card_name">
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" required class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">
                                    I agree to the <a href="#" class="text-blue-600 hover:underline font-semibold">Terms and Conditions</a> 
                                    and <a href="#" class="text-blue-600 hover:underline font-semibold">Cancellation Policy</a>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-4 px-6 rounded-xl font-bold text-lg hover:shadow-xl transform hover:scale-105 transition flex items-center justify-center gap-3">
                            <i class="fas fa-lock"></i>
                            <span>Complete Secure Payment</span>
                        </button>

                        <div class="mt-4 text-center text-sm text-gray-600">
                            <i class="fas fa-shield-alt text-green-600"></i>
                            Your payment information is encrypted and secure
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-receipt text-blue-600"></i>
                        Booking Summary
                    </h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-ticket-alt text-blue-600 mt-1"></i>
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Booking Reference</div>
                                <div class="font-bold text-blue-600">{{ $booking->booking_reference }}</div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="font-bold text-lg mb-2">{{ $booking->tour->title }}</div>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span><i class="far fa-calendar"></i> Date:</span>
                                    <span class="font-semibold">{{ $booking->booking_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span><i class="fas fa-users"></i> Participants:</span>
                                    <span class="font-semibold">{{ $booking->number_of_people }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span><i class="fas fa-clock"></i> Duration:</span>
                                    <span class="font-semibold">{{ $booking->tour->duration_days }} day(s)</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Price per person:</span>
                                    <span>${{ number_format($booking->tour->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Number of participants:</span>
                                    <span>× {{ $booking->number_of_people }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total Amount:</span>
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold mb-1">Flexible Payment Options</p>
                                <p>Choose to pay in full now or secure your booking with a 30% deposit.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs text-gray-600">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-0.5"></i>
                            <span>Free cancellation up to 24 hours</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-0.5"></i>
                            <span>Instant confirmation</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-0.5"></i>
                            <span>24/7 customer support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
    const creditCardDetails = document.getElementById('creditCardDetails');
    
    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardDetails.style.display = 'block';
            } else {
                creditCardDetails.style.display = 'none';
            }
        });
    });

    const cardNumberInput = document.getElementById('card_number');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }

    const cardExpiryInput = document.getElementById('card_expiry');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });
    }
</script>
@endsection
