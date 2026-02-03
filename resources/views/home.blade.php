@extends('layouts.app')

@section('title', 'Home - Amazing Tours with Licensed Guides')

@section('content')
<div class="relative">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            <!-- Banner 1 -->
            <div class="swiper-slide">
                <div class="relative h-[600px] bg-gradient-to-r from-green-900 via-emerald-900 to-green-900" 
                     @if(isset($bannerSettings['banner_1_image']) && $bannerSettings['banner_1_image']->value)
                     style="background-image: url('{{ asset('storage/' . $bannerSettings['banner_1_image']->value) }}'); background-size: cover; background-position: center;"
                     @endif>
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                        <div class="text-white max-w-3xl animate-fadeInUp">
                            <h1 class="text-5xl md:text-7xl font-bold mb-6">{!! str_replace(['Amazing', 'Adventures'], ['Amazing <span class="text-yellow-400">', '</span> Adventures'], $bannerSettings['banner_1_title']->value ?? 'Discover Amazing <span class="text-yellow-400">Adventures</span>') !!}</h1>
                            <p class="text-xl md:text-2xl mb-8">{{ $bannerSettings['banner_1_subtitle']->value ?? 'Experience unforgettable tours with our licensed professional guides' }}</p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('tours.index') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-yellow-300 transform hover:scale-105 transition">
                                    <i class="fas fa-search"></i> Explore Tours
                                </a>
                                <a href="{{ route('contact') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-bold hover:bg-white hover:text-gray-900 transition">
                                    <i class="fas fa-envelope"></i> Contact Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 2 -->
            <div class="swiper-slide">
                <div class="relative h-[600px] bg-gradient-to-r from-emerald-700 via-green-600 to-teal-600"
                     @if(isset($bannerSettings['banner_2_image']) && $bannerSettings['banner_2_image']->value)
                     style="background-image: url('{{ asset('storage/' . $bannerSettings['banner_2_image']->value) }}'); background-size: cover; background-position: center;"
                     @endif>
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                        <div class="text-white max-w-3xl animate-fadeInUp">
                            <h1 class="text-5xl md:text-7xl font-bold mb-6">{!! str_replace(['Expert', 'Guides'], ['<span class="text-yellow-400">Expert', '</span> Guides'], $bannerSettings['banner_2_title']->value ?? 'Licensed <span class="text-yellow-400">Expert Guides</span>') !!}</h1>
                            <p class="text-xl md:text-2xl mb-8">{{ $bannerSettings['banner_2_subtitle']->value ?? 'Travel with certified guides who know every hidden gem' }}</p>
                            <a href="{{ route('tours.index') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-yellow-300 inline-block transform hover:scale-105 transition">
                                View All Tours
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 3 -->
            <div class="swiper-slide">
                <div class="relative h-[600px] bg-gradient-to-r from-green-900 via-emerald-900 to-green-900"
                     @if(isset($bannerSettings['banner_3_image']) && $bannerSettings['banner_3_image']->value)
                     style="background-image: url('{{ asset('storage/' . $bannerSettings['banner_3_image']->value) }}'); background-size: cover; background-position: center;"
                     @endif>
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                        <div class="text-white max-w-3xl animate-fadeInUp">
                            <h1 class="text-5xl md:text-7xl font-bold mb-6">{!! str_replace(['Guarantee'], ['<span class="text-yellow-400">Guarantee</span>'], $bannerSettings['banner_3_title']->value ?? 'Best Price <span class="text-yellow-400">Guarantee</span>') !!}</h1>
                            <p class="text-xl md:text-2xl mb-8">{{ $bannerSettings['banner_3_subtitle']->value ?? 'Premium quality tours at unbeatable prices' }}</p>
                            <a href="{{ route('tours.index') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-yellow-300 inline-block transform hover:scale-105 transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<div class="bg-white py-16 -mt-20 relative z-20">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-2xl p-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-white text-center">
                <div class="animate-fadeInUp" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < 5000) count += 50 }, 10)">
                    <div class="text-5xl font-bold mb-2" x-text="count + '+'"></div>
                    <div class="text-lg">Happy Travelers</div>
                </div>
                <div class="animate-fadeInUp" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < 150) count += 2 }, 20)">
                    <div class="text-5xl font-bold mb-2" x-text="count + '+'"></div>
                    <div class="text-lg">Tours Available</div>
                </div>
                <div class="animate-fadeInUp" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < 50) count += 1 }, 30)">
                    <div class="text-5xl font-bold mb-2" x-text="count + '+'"></div>
                    <div class="text-lg">Expert Guides</div>
                </div>
                <div class="animate-fadeInUp" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < 15) count += 1 }, 100)">
                    <div class="text-5xl font-bold mb-2" x-text="count + ' Years'"></div>
                    <div class="text-lg">Experience</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-20">
    <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Why Choose <span class="gradient-text">Us?</span></h2>
        <p class="text-xl text-gray-600">Experience the best tours with unmatched quality and service</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-8 bg-white rounded-xl shadow-lg card-hover">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 float-animation">
                <i class="fas fa-star text-white text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-4">Top Quality Tours</h3>
            <p class="text-gray-600">Premium private tours at exceptional value with licensed guides</p>
        </div>
        <div class="text-center p-8 bg-white rounded-xl shadow-lg card-hover">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 float-animation" style="animation-delay: 0.2s;">
                <i class="fas fa-shield-alt text-white text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-4">Best Price Guarantee</h3>
            <p class="text-gray-600">Competitive pricing with no hidden fees or extra charges</p>
        </div>
        <div class="text-center p-8 bg-white rounded-xl shadow-lg card-hover">
            <div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6 float-animation" style="animation-delay: 0.4s;">
                <i class="fas fa-heart text-white text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-4">24/7 Support</h3>
            <p class="text-gray-600">Round-the-clock customer support for all your needs</p>
        </div>
    </div>
</div>

@if($categories->count() > 0)
<div class="bg-gray-100 py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">Explore by <span class="gradient-text">Category</span></h2>
            <p class="text-xl text-gray-600">Choose from our diverse range of tour experiences</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('tours.index', ['category' => $category->slug]) }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-2xl transition text-center card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas {{ $category->icon ?? 'fa-map-marker-alt' }} text-white text-3xl"></i>
                </div>
                <h3 class="font-bold mb-2">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600">{{ $category->tours_count }} tours</p>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($featuredTours->count() > 0)
<div class="container mx-auto px-4 py-20">
    <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Featured <span class="gradient-text">Tours</span></h2>
        <p class="text-xl text-gray-600">Hand-picked tours for unforgettable experiences</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($featuredTours as $tour)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
            <div class="relative h-56 overflow-hidden group">
                @if($tour->featured_image)
                <img src="{{ asset('storage/' . $tour->featured_image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                @else
                <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-700 flex items-center justify-center">
                    <i class="fas fa-image text-white text-6xl"></i>
                </div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold">Featured</span>
                </div>
            </div>
            <div class="p-6">
                <span class="text-sm text-green-600 font-semibold">{{ $tour->category->name }}</span>
                <h3 class="text-xl font-bold mt-2 mb-3 hover:text-green-600 transition">{{ $tour->title }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($tour->description, 100) }}</p>
                
                @if($tour->reviews->count() > 0)
                <div class="flex items-center mb-4">
                    @php $avgRating = $tour->reviews->avg('rating'); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                    <span class="text-sm text-gray-600 ml-2">({{ $tour->reviews->count() }})</span>
                </div>
                @endif
                
                <div class="flex justify-between items-center mb-4 text-sm text-gray-600">
                    <span><i class="far fa-clock text-green-600"></i> {{ $tour->duration_days }} day(s)</span>
                    <span><i class="fas fa-users text-green-600"></i> Max {{ $tour->max_participants }}</span>
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t">
                    <div>
                        <span class="text-gray-500 text-sm">From</span>
                        <div class="text-2xl font-bold text-green-600">${{ number_format($tour->price, 0) }}</div>
                    </div>
                    <a href="{{ route('tours.show', $tour->slug) }}" class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-12">
        <a href="{{ route('tours.index') }}" class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-8 py-4 rounded-full font-bold hover:shadow-xl transform hover:scale-105 transition inline-block">
            View All Tours <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
@endif

@if($recentReviews->count() > 0)
<div class="bg-gradient-to-r from-green-900 to-emerald-900 py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">What Our <span class="text-yellow-400">Customers Say</span></h2>
            <p class="text-xl text-gray-200">Real experiences from real travelers</p>
        </div>
        
        <div class="swiper reviewsSwiper">
            <div class="swiper-wrapper">
                @foreach($recentReviews as $review)
                <div class="swiper-slide">
                    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-2xl mx-auto">
                        <div class="flex items-center mb-6">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl"></i>
                            @endfor
                        </div>
                        <p class="text-gray-700 text-lg mb-6 italic">"{{ $review->comment }}"</p>
                        <div class="flex items-center gap-4 border-t pt-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($review->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $review->customer_name }}</p>
                                <p class="text-sm text-gray-600">{{ $review->tour->title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination reviews-pagination"></div>
        </div>
    </div>
</div>
@endif

<div class="container mx-auto px-4 py-20">
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-2xl p-12 text-center text-white">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready for Your Next Adventure?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Book your dream tour today and create memories that will last a lifetime</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('tours.index') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-yellow-300 transform hover:scale-105 transition">
                <i class="fas fa-search"></i> Browse Tours
            </a>
            <a href="{{ route('contact') }}" class="bg-white text-green-600 px-8 py-4 rounded-full font-bold hover:bg-gray-100 transform hover:scale-105 transition">
                <i class="fas fa-phone"></i> Contact Us
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const heroSwiper = new Swiper('.heroSwiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
    });

    const reviewsSwiper = new Swiper('.reviewsSwiper', {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.reviews-pagination',
            clickable: true,
        },
        spaceBetween: 30,
    });

    const lightbox = GLightbox({
        selector: '.glightbox'
    });
</script>
@endpush
