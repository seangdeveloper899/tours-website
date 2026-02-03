@extends('layouts.app')

@section('title', 'All Tours - Browse Our Amazing Tours')

@section('content')
<div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-16 relative overflow-hidden">
    @if(isset($toursSettings['tours_banner_image']) && $toursSettings['tours_banner_image']->value)
        <div class="absolute inset-0 bg-cover bg-center opacity-30" 
             style="background-image: url('{{ asset('storage/' . $toursSettings['tours_banner_image']->value) }}')"></div>
    @endif
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            {{ $toursSettings['tours_banner_title']->value ?? 'Explore Our Tours' }}
        </h1>
        <p class="text-xl">
            {{ $toursSettings['tours_banner_subtitle']->value ?? 'Find your perfect adventure from our collection of amazing tours' }}
        </p>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-1/4">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-green-600"></i> Filters
                </h3>
                
                <form method="GET" action="{{ route('tours.index') }}" id="filterForm">
                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2 text-gray-700">Search Tours</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search..." 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2 text-gray-700">Category</label>
                        <select name="category" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2 text-gray-700">Price Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   placeholder="Min $" 
                                   class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   placeholder="Max $" 
                                   class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2 text-gray-700">Duration (Days)</label>
                        <select name="duration" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                            <option value="">Any Duration</option>
                            <option value="1" {{ request('duration') == '1' ? 'selected' : '' }}>1 Day</option>
                            <option value="2" {{ request('duration') == '2' ? 'selected' : '' }}>2 Days</option>
                            <option value="3" {{ request('duration') == '3' ? 'selected' : '' }}>3 Days</option>
                            <option value="4" {{ request('duration') == '4' ? 'selected' : '' }}>4+ Days</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2 text-gray-700">Sort By</label>
                        <select name="sort" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-700 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                            <i class="fas fa-search"></i> Apply
                        </button>
                        <a href="{{ route('tours.index') }}" class="px-4 py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-100 transition flex items-center">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">{{ $tours->total() }} Tours Found</h2>
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'duration']))
                        <p class="text-gray-600">Showing filtered results</p>
                    @endif
                </div>
            </div>

            @if($tours->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($tours as $tour)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                        <div class="relative h-48 overflow-hidden group">
                            @if($tour->featured_image)
                            <img src="{{ asset('storage/' . $tour->featured_image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-700 flex items-center justify-center">
                                <i class="fas fa-image text-white text-6xl"></i>
                            </div>
                            @endif
                            @if($tour->is_featured)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">Featured</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <span class="text-xs text-green-600 font-semibold">{{ $tour->category->name }}</span>
                            <h3 class="text-lg font-bold mt-2 mb-2 hover:text-green-600 transition line-clamp-2">
                                <a href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($tour->description, 80) }}</p>
                            
                            @if($tour->reviews_count > 0)
                            <div class="flex items-center mb-3">
                                @php $avgRating = $tour->reviews_avg_rating ?? 0; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                                <span class="text-xs text-gray-600 ml-2">({{ $tour->reviews_count }})</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between items-center text-xs text-gray-600 mb-3">
                                <span><i class="far fa-clock text-green-600"></i> {{ $tour->duration_days }}d</span>
                                <span><i class="fas fa-users text-green-600"></i> Max {{ $tour->max_participants }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center pt-3 border-t">
                                <div>
                                    <span class="text-xs text-gray-500">From</span>
                                    <div class="text-xl font-bold text-green-600">${{ number_format($tour->price, 0) }}</div>
                                </div>
                                <a href="{{ route('tours.show', $tour->slug) }}" class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-4 py-2 rounded-full text-sm font-semibold hover:shadow-lg transition">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $tours->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-700 mb-4">No Tours Found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search or filters</p>
                    <a href="{{ route('tours.index') }}" class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg inline-block">
                        Reset Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
