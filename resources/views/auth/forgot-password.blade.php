@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
                <p class="mt-2 text-sm text-gray-600">Enter your email to receive a password reset link</p>
            </div>

            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    Send Reset Link
                </button>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
