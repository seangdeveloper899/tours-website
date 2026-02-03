@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 flex items-center justify-center gap-3">
            <i class="fas fa-headset"></i> Get in Touch
        </h1>
        <p class="text-xl max-w-2xl mx-auto opacity-90">
            Have questions? We're here to help! Our team is ready to assist you with your travel plans.
        </p>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-2xl p-8">
                <h2 class="text-3xl font-bold mb-6 text-gray-800">Send Us a Message</h2>

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
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

                <form action="{{ route('contact') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-user text-green-600"></i> Your Name *
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                                placeholder="John Doe"
                                required
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-envelope text-green-600"></i> Email Address *
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                                placeholder="john@example.com"
                                required
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="phone" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-phone text-green-600"></i> Phone Number
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="phone" 
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                                placeholder="+855 12 345 678"
                            >
                        </div>

                        <div>
                            <label for="subject" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-tag text-green-600"></i> Subject *
                            </label>
                            <select 
                                name="subject" 
                                id="subject"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                                required
                            >
                                <option value="">Select a subject</option>
                                <option value="General Inquiry" {{ old('subject') === 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Tour Information" {{ old('subject') === 'Tour Information' ? 'selected' : '' }}>Tour Information</option>
                                <option value="Booking Support" {{ old('subject') === 'Booking Support' ? 'selected' : '' }}>Booking Support</option>
                                <option value="Custom Tour Request" {{ old('subject') === 'Custom Tour Request' ? 'selected' : '' }}>Custom Tour Request</option>
                                <option value="Feedback" {{ old('subject') === 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-comment-alt text-green-600"></i> Your Message *
                        </label>
                        <textarea 
                            name="message" 
                            id="message" 
                            rows="6"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring focus:ring-green-200 transition"
                            placeholder="Tell us how we can help you..."
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-600 to-emerald-700 text-white py-4 rounded-xl font-bold text-xl hover:shadow-2xl transform hover:scale-105 transition duration-300"
                    >
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Visit Our Office</h3>
                    <p class="text-gray-600 mb-2">123 Siem Reap Road</p>
                    <p class="text-gray-600 mb-2">Siem Reap, Cambodia</p>
                    <a href="#" class="text-green-600 font-semibold hover:underline flex items-center gap-2 mt-3">
                        <i class="fas fa-directions"></i> Get Directions
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-phone text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Call Us</h3>
                    <p class="text-gray-600 mb-1">+855 12 345 678</p>
                    <p class="text-gray-600 mb-1">+855 98 765 432</p>
                    <p class="text-sm text-gray-500 mt-3">Mon-Sat: 8:00 AM - 6:00 PM</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Email Us</h3>
                    <a href="mailto:info@royalangkor-tours.com" class="text-gray-600 hover:text-green-600 transition block mb-1">
                        info@royalangkor-tours.com
                    </a>
                    <a href="mailto:support@royalangkor-tours.com" class="text-gray-600 hover:text-green-600 transition block">
                        support@royalangkor-tours.com
                    </a>
                </div>

                <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="font-bold text-xl mb-4">Follow Us</h3>
                    <div class="flex gap-3">
                        <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-16">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Frequently Asked Questions</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto" x-data="{ openFaq: null }">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full text-left px-6 py-5 font-bold text-lg hover:bg-green-50 transition flex justify-between items-center">
                    <span><i class="fas fa-calendar-check text-green-600"></i> How do I book a tour?</span>
                    <i class="fas" :class="openFaq === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="openFaq === 1" x-collapse class="px-6 pb-5 text-gray-600">
                    Simply browse our tours, select your preferred tour, choose a date, and fill out the booking form. You'll receive confirmation within 24 hours.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full text-left px-6 py-5 font-bold text-lg hover:bg-green-50 transition flex justify-between items-center">
                    <span><i class="fas fa-undo text-green-600"></i> What's your cancellation policy?</span>
                    <i class="fas" :class="openFaq === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="openFaq === 2" x-collapse class="px-6 pb-5 text-gray-600">
                    Free cancellation up to 24 hours before the tour. Cancel within 24 hours for a 50% refund. No refunds for same-day cancellations.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full text-left px-6 py-5 font-bold text-lg hover:bg-green-50 transition flex justify-between items-center">
                    <span><i class="fas fa-dollar-sign text-green-600"></i> When do I need to pay?</span>
                    <i class="fas" :class="openFaq === 3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="openFaq === 3" x-collapse class="px-6 pb-5 text-gray-600">
                    Payment is due on the tour day. We accept cash, credit cards, and mobile payments. A deposit may be required for large groups.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full text-left px-6 py-5 font-bold text-lg hover:bg-green-50 transition flex justify-between items-center">
                    <span><i class="fas fa-users text-green-600"></i> Can I customize a tour?</span>
                    <i class="fas" :class="openFaq === 4 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="openFaq === 4" x-collapse class="px-6 pb-5 text-gray-600">
                    Absolutely! Contact us with your requirements, and we'll create a custom tour tailored to your interests, budget, and schedule.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <button @click="openFaq = openFaq === 5 ? null : 5" class="w-full text-left px-6 py-5 font-bold text-lg hover:bg-green-50 transition flex justify-between items-center">
                    <span><i class="fas fa-car text-green-600"></i> Do you provide hotel pickup?</span>
                    <i class="fas" :class="openFaq === 5 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="openFaq === 5" x-collapse class="px-6 pb-5 text-gray-600">
                    Yes! Hotel pickup is included for most tours. We'll coordinate pickup details after your booking is confirmed.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <button @click="openFaq = openFaq === 6 ? null : 6" class="w-full text-left px-6 py-5 font-bold text-lg hover:bg-green-50 transition flex justify-between items-center">
                    <span><i class="fas fa-language text-green-600"></i> What languages are tours in?</span>
                    <i class="fas" :class="openFaq === 6 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="openFaq === 6" x-collapse class="px-6 pb-5 text-gray-600">
                    Our guides speak English, French, Spanish, Chinese, and Japanese. Let us know your preferred language when booking.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
