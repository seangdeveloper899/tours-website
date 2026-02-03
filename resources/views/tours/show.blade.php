@extends('layouts.app')

@section('title', $tour->title . ' - Tour Details')

@section('content')
<div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-8">
    <div class="container mx-auto px-4">
        <nav class="text-sm mb-4 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-yellow-300 transition">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('tours.index') }}" class="hover:text-yellow-300 transition">Tours</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-yellow-300">{{ $tour->title }}</span>
        </nav>
        <div class="flex flex-wrap justify-between items-end">
            <div>
                <span class="inline-block bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold mb-3">
                    {{ $tour->category->name }}
                </span>
                <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $tour->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    @if($tour->reviews->count() > 0)
                        @php $avgRating = $tour->reviews->avg('rating'); @endphp
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-400' }}"></i>
                            @endfor
                            <span>({{ $tour->reviews->count() }} reviews)</span>
                        </div>
                    @endif
                    <span><i class="far fa-clock"></i> {{ $tour->duration_days }} day(s)</span>
                    <span><i class="fas fa-users"></i> Max {{ $tour->max_participants }} people</span>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <div class="text-sm text-gray-200">Starting from</div>
                <div class="text-4xl font-bold">${{ number_format($tour->price, 0) }}</div>
                <div class="text-sm">per person</div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="mb-8">
                @if($tour->featured_image)
                <div class="relative rounded-xl overflow-hidden shadow-2xl group cursor-pointer">
                    <a href="{{ asset('storage/' . $tour->featured_image) }}" class="glightbox">
                        <img src="{{ asset('storage/' . $tour->featured_image) }}" alt="{{ $tour->title }}" class="w-full h-96 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-4xl opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                    </a>
                </div>
                @else
                <div class="w-full h-96 bg-gradient-to-r from-green-400 to-emerald-700 flex items-center justify-center rounded-xl">
                    <i class="fas fa-image text-white text-8xl"></i>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <i class="fas fa-clock text-3xl text-green-600 mb-2"></i>
                    <div class="text-sm text-gray-600">Duration</div>
                    <div class="font-bold">{{ $tour->duration_days }} Days</div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <i class="fas fa-users text-3xl text-green-600 mb-2"></i>
                    <div class="text-sm text-gray-600">Group Size</div>
                    <div class="font-bold">Max {{ $tour->max_participants }}</div>
                </div>
                @if($tour->difficulty_level)
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <i class="fas fa-chart-line text-3xl text-green-600 mb-2"></i>
                    <div class="text-sm text-gray-600">Difficulty</div>
                    <div class="font-bold">{{ ucfirst($tour->difficulty_level) }}</div>
                </div>
                @endif
                @if($tour->meeting_point)
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-green-600 mb-2"></i>
                    <div class="text-sm text-gray-600">Pickup</div>
                    <div class="font-bold text-sm">Available</div>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-info-circle text-green-600"></i>
                    About This Tour
                </h2>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $tour->description }}</p>
            </div>

            @if($tour->itinerary)
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-route text-green-600"></i>
                    Itinerary
                </h2>
                <div class="prose max-w-none">
                    <pre class="whitespace-pre-wrap text-gray-700 font-sans">{{ $tour->itinerary }}</pre>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @if($tour->included_items && count($tour->included_items) > 0)
                <div class="bg-green-50 rounded-xl shadow-lg p-6 border-2 border-green-200">
                    <h3 class="text-2xl font-bold mb-4 text-green-700 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Included
                    </h3>
                    <ul class="space-y-3">
                        @foreach($tour->included_items as $item)
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($tour->excluded_items && count($tour->excluded_items) > 0)
                <div class="bg-red-50 rounded-xl shadow-lg p-6 border-2 border-red-200">
                    <h3 class="text-2xl font-bold mb-4 text-red-700 flex items-center gap-2">
                        <i class="fas fa-times-circle"></i> Not Included
                    </h3>
                    <ul class="space-y-3">
                        @foreach($tour->excluded_items as $item)
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fas fa-times text-emerald-700 mt-1"></i>
                            <span>{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            @if($tour->reviews->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-star text-yellow-400"></i>
                    Customer Reviews
                </h2>
                
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 mb-8">
                    @php $avgRating = $tour->reviews->avg('rating'); @endphp
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-6xl font-bold text-green-600">{{ number_format($avgRating, 1) }}</div>
                            <div class="flex justify-center my-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xl {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <div class="text-gray-600">{{ $tour->reviews->count() }} reviews</div>
                        </div>
                        <div class="flex-1">
                            @foreach([5,4,3,2,1] as $stars)
                                @php $count = $tour->reviews->where('rating', $stars)->count(); @endphp
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm w-12">{{ $stars }} <i class="fas fa-star text-yellow-400 text-xs"></i></span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $tour->reviews->count() > 0 ? ($count / $tour->reviews->count()) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm w-8 text-gray-600">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach($tour->reviews->take(5) as $review)
                    <div class="border-b pb-6 last:border-b-0">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($review->customer_name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-bold text-lg">{{ $review->customer_name }}</span>
                                    @if($review->is_verified)
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                @if($review->comment)
                                <p class="text-gray-700">{{ $review->comment }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-2xl p-6 sticky top-24 mb-8">
                <div class="text-center mb-6 pb-6 border-b">
                    <span class="text-gray-600">Starting from</span>
                    <h3 class="text-5xl font-bold text-green-600 my-2">${{ number_format($tour->price, 0) }}</h3>
                    <span class="text-gray-600">per person</span>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="far fa-clock w-6 text-green-600"></i>
                        <span>{{ $tour->duration_days }} day(s)</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-users w-6 text-green-600"></i>
                        <span>Max {{ $tour->max_participants }} participants</span>
                    </div>
                    @if($tour->difficulty_level)
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-chart-line w-6 text-green-600"></i>
                        <span>{{ ucfirst($tour->difficulty_level) }} difficulty</span>
                    </div>
                    @endif
                    @if($tour->meeting_point)
                    <div class="flex items-center gap-3 text-gray-700">
                        <i class="fas fa-map-marker-alt w-6 text-green-600"></i>
                        <span class="text-sm">{{ $tour->meeting_point }}</span>
                    </div>
                    @endif
                </div>

                <a href="{{ route('bookings.create', $tour->slug) }}" class="block w-full bg-gradient-to-r from-green-600 to-emerald-700 text-white text-center px-6 py-4 rounded-xl font-bold hover:shadow-xl transform hover:scale-105 transition mb-3">
                    <i class="fas fa-calendar-check"></i> Book This Tour
                </a>
                <a href="{{ route('contact') }}" class="block w-full bg-gray-100 text-gray-700 text-center px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                    <i class="fas fa-envelope"></i> Ask a Question
                </a>

                <div class="mt-6 pt-6 border-t">
                    <div class="flex items-center gap-3 text-sm text-gray-600 mb-2">
                        <i class="fas fa-shield-alt text-green-600"></i>
                        <span>Best Price Guarantee</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600 mb-2">
                        <i class="fas fa-undo text-green-600"></i>
                        <span>Free Cancellation</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fas fa-headset text-green-600"></i>
                        <span>24/7 Support</span>
                    </div>
                </div>
            </div>

            @if($relatedTours->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold mb-4">You May Also Like</h3>
                <div class="space-y-4">
                    @foreach($relatedTours as $relatedTour)
                    <a href="{{ route('tours.show', $relatedTour->slug) }}" class="block group">
                        <div class="flex gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                            @if($relatedTour->featured_image)
                            <img src="{{ asset('storage/' . $relatedTour->featured_image) }}" alt="{{ $relatedTour->title }}" class="w-20 h-20 object-cover rounded-lg">
                            @else
                            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-700 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-white text-2xl"></i>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-bold text-sm group-hover:text-green-600 transition line-clamp-2 mb-1">{{ $relatedTour->title }}</h4>
                                <div class="flex justify-between items-center text-xs text-gray-600">
                                    <span>${{ number_format($relatedTour->price, 0) }}</span>
                                    <span>{{ $relatedTour->duration_days }}d</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true
    });
</script>
@endpush
