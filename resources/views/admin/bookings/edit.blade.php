@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-edit"></i> Edit Booking #{{ $booking->id }}
            </h1>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Customer Information Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-500 mr-3"></i> Customer Information
                    </h2>
                    @if($booking->user)
                        <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 rounded flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-green-800 font-semibold">Registered User (ID: #{{ $booking->user->id }})</span>
                        </div>
                    @else
                        <div class="mb-4 p-3 bg-gray-50 border-l-4 border-gray-400 rounded flex items-center">
                            <i class="fas fa-user-slash text-gray-500 mr-2"></i>
                            <span class="text-gray-700 font-semibold">Guest Booking</span>
                        </div>
                    @endif
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-gray-900">{{ $booking->customer_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-gray-900">{{ $booking->customer_email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-gray-900">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tour Information Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marked-alt text-green-500 mr-3"></i> Tour Information
                    </h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tour</label>
                                <p class="mt-1 text-gray-900">{{ $booking->tour->title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Booking Date</label>
                                <p class="mt-1 text-gray-900">{{ $booking->booking_date->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Participants</label>
                                <p class="mt-1 text-gray-900">{{ $booking->number_of_people }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Price</label>
                                <p class="mt-1 text-gray-900 font-bold">${{ number_format($booking->total_amount, 2) }}</p>
                            </div>
                        </div>
                        @if($booking->special_requirements)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Special Requirements</label>
                            <p class="mt-1 text-gray-900">{{ $booking->special_requirements }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Editable Fields Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-cog text-purple-500 mr-3"></i> Manage Booking
                    </h2>

                    <!-- Booking Status -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Booking Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
                                Confirmed
                            </option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>
                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Current status of the booking</p>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-6">
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Status <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_status" id="payment_status" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent @error('payment_status') border-red-500 @enderror">
                            <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>
                                Unpaid
                            </option>
                            <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>
                                Paid
                            </option>
                            <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>
                                Refunded
                            </option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Payment status for this booking</p>
                    </div>

                    <!-- Assign Guide -->
                    <div class="mb-6">
                        <label for="guide_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Assign Tour Guide (Optional)
                        </label>
                        <select name="guide_id" id="guide_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('guide_id') border-red-500 @enderror">
                            <option value="">-- No Guide Assigned --</option>
                            @foreach($guides as $guide)
                                <option value="{{ $guide->id }}" {{ ($booking->guide_id ?? null) == $guide->id ? 'selected' : '' }}>
                                    {{ $guide->name }} - {{ $guide->languages }} (Rating: {{ $guide->rating }})
                                </option>
                            @endforeach
                        </select>
                        @error('guide_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Select a tour guide for this booking</p>
                    </div>
                </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save"></i> Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
