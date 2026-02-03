@extends('layouts.app')

@section('title', 'Edit Tour')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-edit"></i> Edit Tour
            </h1>
            <a href="{{ route('admin.tours') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back to Tours
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-heading"></i> Tour Title *
                    </label>
                    <input type="text" name="title" value="{{ old('title', $tour->title) }}" 
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <!-- Category -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-tag"></i> Category *
                    </label>
                    <select name="category_id" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $tour->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-dollar-sign"></i> Price (USD) *
                    </label>
                    <input type="number" name="price" value="{{ old('price', $tour->price) }}" step="0.01" min="0"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-clock"></i> Duration (Days) *
                    </label>
                    <input type="number" name="duration_days" value="{{ old('duration_days', $tour->duration_days) }}" min="1"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <!-- Max Participants -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-users"></i> Max Participants *
                    </label>
                    <input type="number" name="max_participants" value="{{ old('max_participants', $tour->max_participants) }}" min="1"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <!-- Difficulty -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-mountain"></i> Difficulty *
                    </label>
                    <select name="difficulty_level" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                        <option value="">Select Difficulty</option>
                        <option value="easy" {{ old('difficulty_level', $tour->difficulty_level) == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="moderate" {{ old('difficulty_level', $tour->difficulty_level) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="challenging" {{ old('difficulty_level', $tour->difficulty_level) == 'challenging' ? 'selected' : '' }}>Challenging</option>
                        <option value="difficult" {{ old('difficulty_level', $tour->difficulty_level) == 'difficult' ? 'selected' : '' }}>Difficult</option>
                    </select>
                </div>

                <!-- Current Featured Image -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        Current Featured Image
                    </label>
                    <img src="{{ asset('storage/' . $tour->featured_image) }}" alt="{{ $tour->title }}" class="h-48 w-auto rounded-lg shadow-md mb-2">
                </div>

                <!-- Featured Image -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-image"></i> Change Featured Image
                    </label>
                    <input type="file" name="featured_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-align-left"></i> Description *
                    </label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>{{ old('description', $tour->description) }}</textarea>
                </div>

                <!-- Itinerary -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-list"></i> Itinerary
                    </label>
                    <textarea name="itinerary" rows="6" 
                              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                              placeholder="Day 1: ...&#10;Day 2: ...">{{ old('itinerary', $tour->itinerary) }}</textarea>
                </div>

                <!-- Included -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-check-circle"></i> What's Included
                    </label>
                    <textarea name="included_items" rows="4" 
                              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                              placeholder="Professional guide&#10;Hotel pickup and drop-off&#10;Entrance fees">{{ old('included_items', is_array($tour->included_items) ? implode("\n", $tour->included_items) : $tour->included_items) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Enter each item on a new line</p>
                </div>

                <!-- Excluded -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-times-circle"></i> What's Excluded
                    </label>
                    <textarea name="excluded_items" rows="4" 
                              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                              placeholder="Personal expenses&#10;Travel insurance&#10;Meals not mentioned">{{ old('excluded_items', is_array($tour->excluded_items) ? implode("\n", $tour->excluded_items) : $tour->excluded_items) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Enter each item on a new line</p>
                </div>

                <!-- Meeting Point -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-map-marker-alt"></i> Meeting Point
                    </label>
                    <input type="text" name="meeting_point" value="{{ old('meeting_point', $tour->meeting_point) }}"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                           placeholder="Hotel lobby or specific address">
                </div>

                <!-- Checkboxes -->
                <div class="md:col-span-2 flex gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $tour->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="ml-2 text-gray-700"><i class="fas fa-star text-yellow-500"></i> Featured Tour</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tour->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="ml-2 text-gray-700"><i class="fas fa-check-circle text-green-500"></i> Active</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.tours') }}" class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                    <i class="fas fa-save"></i> Update Tour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
