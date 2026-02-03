@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
            </h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                </span>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Tours Management Card -->
            <a href="{{ route('admin.tours') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-4xl text-indigo-500">
                        <i class="fas fa-suitcase"></i>
                    </div>
                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Manage
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tours Products</h3>
                <p class="text-gray-600">Add, edit, and manage tour packages</p>
            </a>

            <!-- Bookings Management Card -->
            <a href="{{ route('admin.bookings') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-4xl text-teal-500">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Manage
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Customer Bookings</h3>
                <p class="text-gray-600">View and manage customer bookings</p>
            </a>

            <!-- Banner Management Card -->
            <a href="{{ route('admin.banner') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-4xl text-blue-500">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Manage
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Home Banner</h3>
                <p class="text-gray-600">Update homepage banner images and text</p>
            </a>

            <!-- Tours Banner Card -->
            <a href="{{ route('admin.tours.banner') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-4xl text-orange-500">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Manage
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tours Banner</h3>
                <p class="text-gray-600">Update tours page banner</p>
            </a>

            <!-- Content Management Card -->
            <a href="{{ route('admin.content') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-4xl text-green-500">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Manage
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Content Settings</h3>
                <p class="text-gray-600">Update site content and information</p>
            </a>
        </div>

        <!-- All Settings Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('admin.settings') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-4xl text-purple-500">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                        View All
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">All Settings</h3>
                <p class="text-gray-600">View and edit all site settings</p>
            </a>
        </div>

        <!-- Current Settings Overview -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-list"></i> Settings Overview
            </h2>

            @foreach($settings as $group => $groupSettings)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 capitalize border-b pb-2">
                        <i class="fas fa-folder-open text-gray-500"></i> {{ ucfirst($group) }} Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($groupSettings as $setting)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-1">{{ $setting->key }}</div>
                                @if($setting->type === 'image')
                                    @if($setting->value)
                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->key }}" class="h-20 w-auto rounded">
                                    @else
                                        <span class="text-gray-400 text-sm">No image uploaded</span>
                                    @endif
                                @else
                                    <div class="text-gray-800 text-sm">{{ Str::limit($setting->value ?? 'Not set', 100) }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if($settings->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>No settings configured yet. Start by adding some settings!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
