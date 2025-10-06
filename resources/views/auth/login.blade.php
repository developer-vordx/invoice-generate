
@extends('layouts.app')

@section('title', 'Login - ReconX')

@section('content')

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-xl mb-4">
                <i class="fas fa-exchange-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome to ReconX</h1>
            <p class="text-gray-600 mt-2">Sign in to your account to continue</p>
        </div>

        <div id="errorMessage" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-600"></p>
        </div>

        <form id="loginForm" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="email" id="email" required
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your email">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" id="password" required
                           class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your password">
                    <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="{{route('password.request')}}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Forgot password?
                </a>
            </div>

            <button type="submit" id="loginButton"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Sign In
            </button>
        </form>

    </div>

    <div class="text-center mt-6 text-sm text-gray-600">
        <p>&copy; 2025 ReconX. All rights reserved.</p>
    </div>
</div>

<script src="auth.js"></script>
@endsection
