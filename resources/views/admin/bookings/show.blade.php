@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-calendar-check"></i> Booking #{{ $booking->id }}
            </h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-600 transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.bookings') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-500 mr-3"></i> Customer Information
                    </h2>
                    <div class="space-y-3">
                        @if($booking->user)
                            <div class="flex items-start mb-3 p-3 bg-green-50 border-l-4 border-green-500 rounded">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                <div>
                                    <span class="text-green-800 font-semibold">Registered User</span>
                                    <p class="text-sm text-green-600">User ID: #{{ $booking->user->id }} | Member since {{ $booking->user->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start mb-3 p-3 bg-gray-50 border-l-4 border-gray-400 rounded">
                                <i class="fas fa-user-slash text-gray-500 mr-2 mt-1"></i>
                                <div>
                                    <span class="text-gray-700 font-semibold">Guest Booking</span>
                                    <p class="text-sm text-gray-600">Not linked to a user account</p>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Name:</span>
                            <span class="text-gray-900 font-semibold">{{ $booking->customer_name }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Email:</span>
                            <a href="mailto:{{ $booking->customer_email }}" class="text-blue-600 hover:underline">
                                {{ $booking->customer_email }}
                            </a>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Phone:</span>
                            <a href="tel:{{ $booking->customer_phone }}" class="text-blue-600 hover:underline">
                                {{ $booking->customer_phone }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marked-alt text-green-500 mr-3"></i> Tour Information
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Tour:</span>
                            <span class="text-gray-900 font-semibold">{{ $booking->tour->title }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Category:</span>
                            <span class="text-gray-900">{{ $booking->tour->category->name }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Duration:</span>
                            <span class="text-gray-900">{{ $booking->tour->duration_days }} days</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Price per person:</span>
                            <span class="text-gray-900">${{ number_format($booking->tour->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-purple-500 mr-3"></i> Booking Details
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Booking Date:</span>
                            <span class="text-gray-900">{{ $booking->booking_date->format('F d, Y') }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Participants:</span>
                            <span class="text-gray-900 font-semibold">{{ $booking->number_of_people }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Total Price:</span>
                            <span class="text-gray-900 font-bold text-lg">${{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        @if($booking->guide)
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Assigned Guide:</span>
                            <span class="text-gray-900">{{ $booking->guide->name }}</span>
                        </div>
                        @endif
                        @if($booking->special_requests)
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Special Requests:</span>
                            <span class="text-gray-900">{{ $booking->special_requests }}</span>
                        </div>
                        @endif
                        <div class="flex items-start">
                            <span class="text-gray-600 w-40 font-medium">Created:</span>
                            <span class="text-gray-900">{{ $booking->created_at->format('F d, Y \a\t h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-chart-line"></i> Status
                    </h3>
                    
                    <!-- Booking Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Booking Status</label>
                        <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                            @csrf
                            <div class="flex gap-2">
                                <select name="status" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                        <form action="{{ route('admin.bookings.payment', $booking->id) }}" method="POST">
                            @csrf
                            <div class="flex gap-2">
                                <select name="payment_status" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partial" {{ $booking->payment_status === 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Assign Guide -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign Tour Guide</label>
                        <form action="{{ route('admin.bookings.assign-guide', $booking->id) }}" method="POST">
                            @csrf
                            <div class="flex gap-2">
                                <select name="guide_id" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">-- Select Guide --</option>
                                    @foreach(\App\Models\Guide::where('is_available', true)->get() as $guide)
                                        <option value="{{ $guide->id }}" {{ ($booking->guide_id ?? null) == $guide->id ? 'selected' : '' }}>
                                            {{ $guide->name }} ({{ $guide->rating }}★)
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                                    <i class="fas fa-save"></i>     
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-tools"></i> Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="block w-full text-center bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                            <i class="fas fa-edit"></i> Edit Booking
                        </a>
                        <a href="{{ route('admin.bookings.transactions', $booking->id) }}" class="block w-full text-center bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-history"></i> Transaction History
                        </a>
                        @if($booking->total_paid > 0)
                        <button onclick="document.getElementById('refundModal').classList.remove('hidden')" 
                                class="block w-full bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">
                            <i class="fas fa-undo"></i> Process Refund
                        </button>
                        @endif
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                <i class="fas fa-trash"></i> Delete Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Process Refund</h3>
                <button onclick="document.getElementById('refundModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.bookings.refund', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Refund Amount</label>
                    <input type="number" name="amount" step="0.01" max="{{ $transactionHistory['total_paid'] ?? 0 }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                    <p class="text-xs text-gray-500 mt-1">Maximum: ${{ number_format($transactionHistory['total_paid'] ?? 0, 2) }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                    <textarea name="reason" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('refundModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                        Process Refund
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
