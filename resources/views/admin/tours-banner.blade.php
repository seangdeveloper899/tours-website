@extends('layouts.app')

@section('title', 'Tours Banner Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-map-marked-alt"></i> Tours Banner Management
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.tours.banner.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Banner Title -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-heading"></i> Banner Title
                    </label>
                    <input type="text" name="tours_banner_title" 
                           value="{{ old('tours_banner_title', $toursSettings['tours_banner_title']->value ?? 'Explore Our Tours') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Main heading text for the tours page banner</p>
                </div>

                <!-- Banner Subtitle -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-align-left"></i> Banner Subtitle
                    </label>
                    <textarea name="tours_banner_subtitle" rows="3"
                              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                              required>{{ old('tours_banner_subtitle', $toursSettings['tours_banner_subtitle']->value ?? 'Find your perfect adventure from our collection of amazing tours') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Subtitle or description text below the title</p>
                </div>

                <!-- Banner Background Image -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-image"></i> Banner Background Image
                    </label>
                    
                    @if(isset($toursSettings['tours_banner_image']) && $toursSettings['tours_banner_image']->value)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <img src="{{ asset('storage/' . $toursSettings['tours_banner_image']->value) }}" 
                                 alt="Current Tours Banner" 
                                 class="h-48 w-auto rounded-lg shadow-md">
                        </div>
                    @endif
                    
                    <input type="file" name="tours_banner_image" 
                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <p class="text-sm text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</p>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        <i class="fas fa-save"></i> Update Tours Banner
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mt-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-eye"></i> Current Preview
            </h2>
            <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-16 rounded-lg relative overflow-hidden">
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
        </div>
    </div>
</div>
@endsection
