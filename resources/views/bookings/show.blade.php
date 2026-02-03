@extends('layouts.app')

@section('title', 'Booking Confirmation')

@section('content')
<div class="bg-gradient-to-r from-green-500 to-teal-600 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <div class="animate-bounce mb-6">
            <i class="fas fa-check-circle text-8xl"></i>
        </div>
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
            @if($booking->payment_status === 'paid')
                Payment Confirmed!
            @else
                Booking Confirmed!
            @endif
        </h1>
        <p class="text-xl mb-2">Thank you for choosing Royal Angkor Tours</p>
        <p class="text-lg opacity-90">Your adventure awaits!</p>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl shadow-lg p-8 mb-8 text-center border-2 border-green-200">
            <div class="text-sm text-gray-600 mb-2">Booking Reference Number</div>
            <div class="text-4xl font-bold text-green-600 tracking-wider mb-4">{{ $booking->booking_reference }}</div>
            <p class="text-gray-700">
                <i class="fas fa-info-circle text-green-600"></i> 
                Please save this reference number for your records
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-8 py-6">
                <h2 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fas fa-ticket-alt"></i>
                    Booking Details
                </h2>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-green-600">
                            <i class="fas fa-map-marked-alt"></i> Tour Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-500 block mb-1">Tour Name</label>
                                <p class="font-semibold text-lg">{{ $booking->tour->title }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 block mb-1">Category</label>
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $booking->tour->category->name }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 block mb-1">Duration</label>
                                <p class="font-semibold">{{ $booking->tour->duration_days }} day(s)</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-green-600">
                            <i class="fas fa-user-circle"></i> Customer Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-500 block mb-1">Full Name</label>
                                <p class="font-semibold">{{ $booking->customer_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 block mb-1">Email</label>
                                <p class="font-semibold">{{ $booking->customer_email }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 block mb-1">Phone</label>
                                <p class="font-semibold">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <i class="far fa-calendar-alt text-4xl text-green-600 mb-3"></i>
                            <div class="text-sm text-gray-600 mb-1">Tour Date</div>
                            <div class="text-xl font-bold">{{ $booking->booking_date->format('M d, Y') }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <i class="fas fa-users text-4xl text-green-600 mb-3"></i>
                            <div class="text-sm text-gray-600 mb-1">Participants</div>
                            <div class="text-xl font-bold">{{ $booking->number_of_people }} person(s)</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <i class="fas fa-dollar-sign text-4xl text-green-600 mb-3"></i>
                            <div class="text-sm text-gray-600 mb-1">Total Amount</div>
                            <div class="text-xl font-bold">${{ number_format($booking->total_price, 2) }}</div>
                        </div>
                    </div>

                    @if($booking->payment_status !== 'unpaid')
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl mb-6">
                        <h4 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-credit-card"></i> Payment Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="ml-2 font-bold
                                    @if($booking->payment_status === 'paid') text-green-700
                                    @elseif($booking->payment_status === 'partial') text-yellow-700
                                    @else text-red-700
                                    @endif">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </div>
                            @if($booking->payment_method)
                            <div>
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="ml-2 font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</span>
                            </div>
                            @endif
                            @if($booking->transaction_id)
                            <div>
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="ml-2 font-mono text-sm font-semibold text-gray-800">{{ $booking->transaction_id }}</span>
                            </div>
                            @endif
                            @if($booking->payment_date)
                            <div>
                                <span class="text-gray-600">Payment Date:</span>
                                <span class="ml-2 font-semibold text-gray-800">{{ $booking->payment_date->format('M d, Y') }}</span>
                            </div>
                            @endif
                            @if($booking->payment_status === 'partial')
                            <div class="md:col-span-2">
                                <span class="text-gray-600">Deposit Paid:</span>
                                <span class="ml-2 font-bold text-green-700">${{ number_format($booking->deposit_amount, 2) }}</span>
                                <span class="ml-4 text-gray-600">Remaining:</span>
                                <span class="ml-2 font-bold text-orange-700">${{ number_format($booking->total_price - $booking->deposit_amount, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-r-xl mb-6">
                        <h4 class="font-bold text-yellow-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i> Payment Pending
                        </h4>
                        <p class="text-gray-700 mb-4">Your booking is confirmed but payment is still pending. Please complete your payment to secure your spot.</p>
                        <a href="{{ route('bookings.checkout', $booking->id) }}" class="inline-block bg-yellow-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-yellow-700 transition">
                            <i class="fas fa-credit-card"></i> Complete Payment Now
                        </a>
                    </div>
                    @endif

                    @if($booking->special_requests)
                    <div class="bg-purple-50 border-l-4 border-purple-400 p-6 rounded-r-xl mb-6">
                        <h4 class="font-bold text-purple-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-comment-dots"></i> Special Requests
                        </h4>
                        <p class="text-gray-700">{{ $booking->special_requests }}</p>
                    </div>
                    @endif
                </div>

                <div class="border-t pt-8 mt-8">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <span class="text-gray-700 font-semibold">Booking Status:</span>
                        <span class="inline-block px-6 py-2 rounded-full text-sm font-bold
                            @if($booking->status === 'confirmed') bg-green-100 text-green-700
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold mb-6 flex items-center gap-3 text-green-600">
                <i class="fas fa-list-check"></i> What Happens Next?
            </h3>
            <div class="space-y-4">
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-green-600">1</span>
                    </div>
                    <div>
                        <h4 class="font-bold mb-1">Confirmation Email</h4>
                        <p class="text-gray-600">You'll receive a confirmation email at <span class="font-semibold">{{ $booking->customer_email }}</span> with all tour details and instructions.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-green-600">2</span>
                    </div>
                    <div>
                        <h4 class="font-bold mb-1">Pre-Tour Information</h4>
                        <p class="text-gray-600">48 hours before your tour, you'll receive detailed pickup instructions and what to bring.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-green-600">3</span>
                    </div>
                    <div>
                        <h4 class="font-bold mb-1">Tour Day</h4>
                        <p class="text-gray-600">Our guide will meet you at the designated pickup location. Have your booking reference ready!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('home') }}" class="block bg-gradient-to-r from-green-600 to-emerald-700 text-white text-center px-6 py-4 rounded-xl font-bold hover:shadow-xl transform hover:scale-105 transition">
                <i class="fas fa-home"></i> Back to Home
            </a>
            @if(isset($transactionHistory) && $transactionHistory['transactions']->count() > 0)
            <a href="{{ route('bookings.transactions', $booking->id) }}" class="block bg-blue-600 text-white text-center px-6 py-4 rounded-xl font-bold hover:bg-blue-700 transition">
                <i class="fas fa-history"></i> View Transaction History
            </a>
            @endif
            <a href="{{ route('tours.index') }}" class="block bg-white border-2 border-green-600 text-green-600 text-center px-6 py-4 rounded-xl font-bold hover:bg-green-50 transition">
                <i class="fas fa-binoculars"></i> Browse More Tours
            </a>
            <a href="{{ route('contact') }}" class="block bg-white border-2 border-gray-300 text-gray-700 text-center px-6 py-4 rounded-xl font-bold hover:bg-gray-50 transition">
                <i class="fas fa-headset"></i> Contact Support
            </a>
        </div>

        <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl p-6">
            <h4 class="font-bold text-emerald-800 mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Important Information
            </h4>
            <ul class="space-y-2 text-gray-700 text-sm">
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-emerald-700 mt-1"></i>
                    <span><strong>Free Cancellation:</strong> Cancel up to 24 hours before your tour for a full refund.</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-emerald-700 mt-1"></i>
                    <span><strong>Weather Policy:</strong> Tours run rain or shine. In case of extreme weather, we'll contact you with alternatives.</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-emerald-700 mt-1"></i>
                    <span><strong>Payment:</strong> 
                        @if($booking->payment_status === 'paid')
                            Payment completed. Thank you!
                        @elseif($booking->payment_status === 'partial')
                            Deposit received. Remaining balance can be paid before or on the tour day.
                        @else
                            Payment can be made on the tour day or <a href="{{ route('bookings.checkout', $booking->id) }}" class="text-blue-600 hover:underline font-semibold">pay online now</a>.
                        @endif
                        We accept cash, credit cards, and mobile payments.
                    </span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-emerald-700 mt-1"></i>
                    <span><strong>Contact:</strong> For any questions, call us at <strong>+855 12 345 678</strong> or email <strong>info@royalangkor-tours.com</strong></span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
