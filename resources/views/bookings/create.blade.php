@extends('layouts.app')

@section('title', 'Book ' . $tour->title)

@section('content')
<div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-12">
    <div class="container mx-auto px-4">
        <nav class="text-sm mb-4 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-yellow-300 transition">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('tours.index') }}" class="hover:text-yellow-300 transition">Tours</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('tours.show', $tour->slug) }}" class="hover:text-yellow-300 transition">{{ $tour->title }}</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-yellow-300">Book Tour</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-bold flex items-center gap-3">
            <i class="fas fa-calendar-check"></i>
            Book Your Tour
        </h1>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-2xl p-8">
                <h2 class="text-3xl font-bold mb-6 text-gray-800">Booking Details</h2>

                @guest
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-blue-800 mb-2">Already have an account?</h3>
                                <p class="text-blue-700 mb-2">
                                    <a href="{{ route('login') }}" class="underline hover:text-blue-900">Sign in</a> to quickly fill your information and track your bookings!
                                </p>
                                <p class="text-sm text-blue-600">
                                    Don't have an account? <a href="{{ route('register') }}" class="underline hover:text-blue-900">Create one</a> for a better booking experience.
                                </p>
                            </div>
                        </div>
                    </div>
                @endguest

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-red-800 mb-2">Please correct the following errors:</h3>
                                <ul class="list-disc list-inside text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('bookings.store', $tour->slug) }}" method="POST" id="bookingForm" x-data="bookingForm()">
                    @csrf
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                    <div class="mb-6">
                        <label for="customer_name" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-user text-green-600"></i> Full Name *
                        </label>
                        <input 
                            type="text" 
                            name="customer_name" 
                            id="customer_name" 
                            value="{{ old('customer_name', Auth::user()->name ?? '') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                            placeholder="Enter your full name"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label for="customer_email" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-envelope text-green-600"></i> Email Address *
                        </label>
                        <input 
                            type="email" 
                            name="customer_email" 
                            id="customer_email" 
                            value="{{ old('customer_email', Auth::user()->email ?? '') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                            placeholder="your.email@example.com"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label for="customer_phone" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-phone text-green-600"></i> Phone Number *
                        </label>
                        <input 
                            type="tel" 
                            name="customer_phone" 
                            id="customer_phone" 
                            value="{{ old('customer_phone', Auth::user()->phone ?? '') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                            placeholder="+1 (555) 123-4567"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label for="booking_date" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-calendar-alt text-green-600"></i> Preferred Tour Date *
                        </label>
                        <input 
                            type="date" 
                            name="booking_date" 
                            id="booking_date" 
                            value="{{ old('booking_date') }}"
                            min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                            required
                        >
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle"></i> Bookings must be made at least 2 days in advance
                        </p>
                    </div>

                    <div class="mb-6">
                        <label for="number_of_people" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-users text-green-600"></i> Number of People *
                        </label>
                        <div class="flex items-center gap-4">
                            <button 
                                type="button" 
                                @click="decreaseParticipants()"
                                class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-xl font-bold text-xl transition"
                            >
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                name="number_of_people" 
                                id="number_of_people" 
                                value="{{ old('number_of_people', 1) }}"
                                min="1" 
                                max="{{ $tour->max_people }}"
                                x-model="participants"
                                class="flex-1 text-center px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition text-2xl font-bold"
                                required
                            >
                            <button 
                                type="button" 
                                @click="increaseParticipants({{ $tour->max_people }})"
                                class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-xl font-bold text-xl transition"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle"></i> Maximum {{ $tour->max_participants }} participants allowed
                        </p>
                    </div>

                    <div class="mb-6">
                        <label for="special_requirements" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-clipboard-list"></i> Special Requirements (Optional)
                        </label>
                        <textarea 
                            name="special_requirements" 
                            id="special_requirements"
                            rows="4"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                            placeholder="Any special requests or dietary requirements?"
                        >{{ old('special_requirements') }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input 
                                type="checkbox" 
                                name="terms" 
                                required
                                class="w-5 h-5 mt-1 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500"
                            >
                            <span class="text-gray-700 group-hover:text-green-600 transition">
                                I agree to the <a href="#" class="text-green-600 font-semibold hover:underline">Terms & Conditions</a> 
                                and <a href="#" class="text-green-600 font-semibold hover:underline">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Price per person:</span>
                            <span class="font-semibold">${{ number_format($tour->price, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Number of participants:</span>
                            <span class="font-semibold" x-text="participants"></span>
                        </div>
                        <div class="border-t pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-800">Total Amount:</span>
                                <span class="text-3xl font-bold text-green-600" x-text="'$' + formatPrice(totalPrice)"></span>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-600 to-emerald-700 text-white py-4 rounded-xl font-bold text-xl hover:shadow-2xl transform hover:scale-105 transition duration-300"
                    >
                        <i class="fas fa-lock"></i> Confirm Booking
                    </button>

                    <p class="text-center text-sm text-gray-500 mt-4">
                        <i class="fas fa-shield-alt text-green-600"></i> Your payment is secure and encrypted
                    </p>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-2xl p-6 sticky top-24">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Tour Summary</h3>
                
                @if($tour->featured_image)
                <img src="{{ asset('storage/' . $tour->featured_image) }}" alt="{{ $tour->title }}" class="w-full h-48 object-cover rounded-xl mb-4">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-green-400 to-emerald-700 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-image text-white text-6xl"></i>
                </div>
                @endif

                <h4 class="font-bold text-xl mb-4">{{ $tour->title }}</h4>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-tag w-5 text-green-600"></i>
                        <span>{{ $tour->category->name }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="far fa-clock w-5 text-green-600"></i>
                        <span>{{ $tour->duration_days }} day(s)</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-users w-5 text-green-600"></i>
                        <span>Max {{ $tour->max_participants }} people</span>
                    </div>
                    @if($tour->difficulty_level)
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-chart-line w-5 text-green-600"></i>
                        <span>{{ ucfirst($tour->difficulty_level) }}</span>
                    </div>
                    @endif
                    @if($tour->reviews->count() > 0)
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-star w-5 text-yellow-400"></i>
                        <span>{{ number_format($tour->reviews->avg('rating'), 1) }} ({{ $tour->reviews->count() }} reviews)</span>
                    </div>
                    @endif
                </div>

                <div class="border-t pt-4">
                    <h5 class="font-bold text-sm text-gray-700 mb-3">What's Included:</h5>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Professional guide</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>All entrance fees</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Hotel pickup</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Free cancellation</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-6 pt-6 border-t">
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-headset text-green-600 text-xl"></i>
                        <span>Need help? <a href="{{ route('contact') }}" class="text-green-600 font-semibold hover:underline">Contact us</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function bookingForm() {
    return {
        participants: {!! old('number_of_people', 1) !!},
        pricePerPerson: {!! $tour->price !!},
        
        get totalPrice() {
            return this.participants * this.pricePerPerson;
        },
        
        increaseParticipants(max) {
            if (this.participants < max) {
                this.participants++;
            }
        },
        
        decreaseParticipants() {
            if (this.participants > 1) {
                this.participants--;
            }
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('en-US').format(price);
        }
    }
}
</script>
@endsection
