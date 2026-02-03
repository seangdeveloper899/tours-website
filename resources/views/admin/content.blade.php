@extends('layouts.app')

@section('title', 'Content Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-file-alt"></i> Content Settings
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

        <form action="{{ route('admin.content.update') }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
            @csrf

            <!-- Site Information -->
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Site Information</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Site Name</label>
                    <input type="text" name="site_name" value="{{ $contentSettings['site_name']->value ?? 'Tours Website' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Site Tagline</label>
                    <input type="text" name="site_tagline" value="{{ $contentSettings['site_tagline']->value ?? 'Experience Amazing Tours with Licensed Guides' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
            </div>

            <!-- About Section -->
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">About Section</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">About Title</label>
                    <input type="text" name="about_title" value="{{ $contentSettings['about_title']->value ?? 'About Our Tours' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">About Description</label>
                    <textarea name="about_description" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>{{ $contentSettings['about_description']->value ?? 'We offer amazing tours with professional licensed guides. Discover the beauty and culture with our expert team.' }}</textarea>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Contact Information</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                    <input type="email" name="contact_email" value="{{ $contentSettings['contact_email']->value ?? 'info@tours-website.com' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="text" name="contact_phone" value="{{ $contentSettings['contact_phone']->value ?? '+1 234 567 890' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Address</label>
                    <input type="text" name="contact_address" value="{{ $contentSettings['contact_address']->value ?? '123 Main St, City' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-save"></i> Save Content Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
