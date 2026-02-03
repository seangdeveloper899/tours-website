@extends('layouts.app')

@section('title', 'Banner Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-image"></i> Banner Settings
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
            @csrf

            <!-- Banner 1 -->
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Banner 1</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" name="banner_1_title" value="{{ $bannerSettings['banner_1_title']->value ?? 'Discover Amazing Adventures' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Subtitle</label>
                    <textarea name="banner_1_subtitle" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>{{ $bannerSettings['banner_1_subtitle']->value ?? 'Experience unforgettable tours with our licensed professional guides' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Background Image</label>
                    @if(isset($bannerSettings['banner_1_image']) && $bannerSettings['banner_1_image']->value)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $bannerSettings['banner_1_image']->value) }}" alt="Banner 1" class="h-40 rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="banner_1_image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                </div>
            </div>

            <!-- Banner 2 -->
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Banner 2</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" name="banner_2_title" value="{{ $bannerSettings['banner_2_title']->value ?? 'Licensed Expert Guides' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Subtitle</label>
                    <textarea name="banner_2_subtitle" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>{{ $bannerSettings['banner_2_subtitle']->value ?? 'Travel with certified guides who know every hidden gem' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Background Image</label>
                    @if(isset($bannerSettings['banner_2_image']) && $bannerSettings['banner_2_image']->value)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $bannerSettings['banner_2_image']->value) }}" alt="Banner 2" class="h-40 rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="banner_2_image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                </div>
            </div>

            <!-- Banner 3 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Banner 3</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" name="banner_3_title" value="{{ $bannerSettings['banner_3_title']->value ?? 'Best Price Guarantee' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Subtitle</label>
                    <textarea name="banner_3_subtitle" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>{{ $bannerSettings['banner_3_subtitle']->value ?? 'Premium quality tours at unbeatable prices' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Background Image</label>
                    @if(isset($bannerSettings['banner_3_image']) && $bannerSettings['banner_3_image']->value)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $bannerSettings['banner_3_image']->value) }}" alt="Banner 3" class="h-40 rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="banner_3_image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-save"></i> Save Banner Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
