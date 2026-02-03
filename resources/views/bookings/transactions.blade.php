@extends('layouts.app')

@section('title', 'Transaction History')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <i class="fas fa-history text-5xl mb-4 opacity-90"></i>
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Transaction History</h1>
            <p class="text-xl opacity-90">Booking Reference: {{ $booking->booking_reference }}</p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-5xl mx-auto">
        <!-- Financial Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-dollar-sign text-4xl text-blue-600 mb-3"></i>
                <div class="text-sm text-blue-600 mb-1">Total Booking Amount</div>
                <div class="text-3xl font-bold text-blue-900">${{ number_format($transactionHistory['booking_total'], 2) }}</div>
            </div>

            <div class="bg-green-50 rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-check-circle text-4xl text-green-600 mb-3"></i>
                <div class="text-sm text-green-600 mb-1">Total Paid</div>
                <div class="text-3xl font-bold text-green-900">${{ number_format($transactionHistory['total_paid'], 2) }}</div>
            </div>

            <div class="bg-orange-50 rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-hourglass-half text-4xl text-orange-600 mb-3"></i>
                <div class="text-sm text-orange-600 mb-1">Remaining Balance</div>
                <div class="text-3xl font-bold text-orange-900">${{ number_format($transactionHistory['remaining_balance'], 2) }}</div>
            </div>
        </div>

        <!-- Booking Info -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-info-circle text-blue-600"></i> Booking Details
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-gray-600">Tour</div>
                    <div class="font-semibold text-lg">{{ $booking->tour->title }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Booking Date</div>
                    <div class="font-semibold">{{ $booking->booking_date->format('F d, Y') }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Customer Name</div>
                    <div class="font-semibold">{{ $booking->customer_name }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Participants</div>
                    <div class="font-semibold">{{ $booking->number_of_people }} person(s)</div>
                </div>
            </div>
        </div>

        <!-- Transactions -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">
                    <i class="fas fa-receipt"></i> Payment Transactions
                </h2>
            </div>

            @if($transactionHistory['transactions']->count() > 0)
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($transactionHistory['transactions'] as $transaction)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($transaction->transaction_type === 'payment') bg-blue-100 text-blue-800
                                        @elseif($transaction->transaction_type === 'refund') bg-orange-100 text-orange-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($transaction->transaction_type) }}
                                    </span>
                                    @if($transaction->status === 'completed')
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </span>
                                    @elseif($transaction->status === 'processing')
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-spinner"></i> Processing
                                        </span>
                                    @elseif($transaction->status === 'failed')
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle"></i> Failed
                                        </span>
                                    @endif
                                </div>
                                <div class="text-2xl font-bold mb-2
                                    @if($transaction->amount >= 0) text-green-600
                                    @else text-red-600
                                    @endif">
                                    @if($transaction->amount >= 0)
                                        ${{ number_format($transaction->amount, 2) }}
                                    @else
                                        -${{ number_format(abs($transaction->amount), 2) }}
                                    @endif
                                </div>
                                @if($transaction->description)
                                <p class="text-gray-700 mb-2">{{ $transaction->description }}</p>
                                @endif
                                <div class="text-sm text-gray-500">
                                    <i class="far fa-calendar"></i> {{ $transaction->created_at->format('F d, Y \a\t h:i A') }}
                                </div>
                            </div>
                            <div class="text-right">
                                @if($transaction->payment_method)
                                <div class="text-sm text-gray-600 mb-1">
                                    <i class="
                                        @if($transaction->payment_method === 'credit_card') fas fa-credit-card text-blue-600
                                        @elseif($transaction->payment_method === 'paypal') fab fa-paypal text-blue-500
                                        @elseif($transaction->payment_method === 'bank_transfer') fas fa-university text-green-600
                                        @elseif($transaction->payment_method === 'cash') fas fa-money-bill-wave text-green-700
                                        @endif
                                    "></i>
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                </div>
                                @endif
                                <div class="text-xs text-gray-400 font-mono">
                                    {{ $transaction->transaction_id }}
                                </div>
                            </div>
                        </div>
                        @if($transaction->gateway_response)
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r">
                            <p class="text-sm text-red-700">{{ $transaction->gateway_response }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-inbox text-5xl mb-4"></i>
                <p class="text-lg">No transactions found</p>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('bookings.show', $booking->id) }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                <i class="fas fa-arrow-left"></i> Back to Booking
            </a>
            @if($transactionHistory['remaining_balance'] > 0)
            <a href="{{ route('bookings.checkout', $booking->id) }}" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 transition">
                <i class="fas fa-credit-card"></i> Pay Remaining Balance
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
