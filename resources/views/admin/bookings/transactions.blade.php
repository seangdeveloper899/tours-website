@extends('layouts.app')

@section('title', 'Transaction History')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-history"></i> Transaction History
            </h1>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back to Booking
            </a>
        </div>

        <!-- Booking Summary -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Booking Reference</div>
                    <div class="font-bold text-lg text-blue-600">{{ $booking->booking_reference }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Customer</div>
                    <div class="font-semibold flex items-center">
                        {{ $booking->customer_name }}
                        @if($booking->user)
                            <i class="fas fa-user-check text-green-500 ml-2" title="Registered User"></i>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Tour</div>
                    <div class="font-semibold">{{ $booking->tour->title }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Booking Date</div>
                    <div class="font-semibold">{{ $booking->booking_date->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Total Amount</p>
                        <p class="text-3xl font-bold text-blue-900">${{ number_format($transactionHistory['booking_total'], 2) }}</p>
                    </div>
                    <div class="text-4xl text-blue-500">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Total Paid</p>
                        <p class="text-3xl font-bold text-green-900">${{ number_format($transactionHistory['total_paid'], 2) }}</p>
                    </div>
                    <div class="text-4xl text-green-500">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-600 text-sm font-medium">Remaining Balance</p>
                        <p class="text-3xl font-bold text-orange-900">${{ number_format($transactionHistory['remaining_balance'], 2) }}</p>
                    </div>
                    <div class="text-4xl text-orange-500">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-medium">Total Transactions</p>
                        <p class="text-3xl font-bold text-purple-900">{{ $transactionHistory['transactions']->count() }}</p>
                    </div>
                    <div class="text-4xl text-purple-500">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-receipt"></i> All Transactions
                </h2>
            </div>

            @if($transactionHistory['transactions']->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactionHistory['transactions'] as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono text-gray-900">{{ $transaction->transaction_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($transaction->transaction_type === 'payment') bg-blue-100 text-blue-800
                                    @elseif($transaction->transaction_type === 'refund') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($transaction->transaction_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($transaction->payment_method)
                                    <i class="
                                        @if($transaction->payment_method === 'credit_card') fas fa-credit-card text-blue-600
                                        @elseif($transaction->payment_method === 'paypal') fab fa-paypal text-blue-500
                                        @elseif($transaction->payment_method === 'bank_transfer') fas fa-university text-green-600
                                        @elseif($transaction->payment_method === 'cash') fas fa-money-bill-wave text-green-700
                                        @endif
                                    "></i>
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold
                                    @if($transaction->amount >= 0) text-green-600
                                    @else text-red-600
                                    @endif">
                                    @if($transaction->amount >= 0)
                                        +${{ number_format($transaction->amount, 2) }}
                                    @else
                                        -${{ number_format(abs($transaction->amount), 2) }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->status === 'completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Completed
                                    </span>
                                @elseif($transaction->status === 'processing')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-spinner mr-1"></i> Processing
                                    </span>
                                @elseif($transaction->status === 'failed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Failed
                                    </span>
                                @elseif($transaction->status === 'refunded')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                        <i class="fas fa-undo mr-1"></i> Refunded
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $transaction->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $transaction->description ?? '-' }}</div>
                                @if($transaction->gateway_response)
                                    <div class="text-xs text-red-600 mt-1">{{ $transaction->gateway_response }}</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-12 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>No transactions found for this booking</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
