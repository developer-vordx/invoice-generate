@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen p-4 bg-black/90">
        <div class="bg-gray-800 w-full max-w-2xl rounded-2xl shadow-xl p-6 sm:p-10 border border-gray-700">

            <!-- Logo & Progress Bar Section -->
            <div class="flex flex-col items-center w-full mb-8">
                <div class="mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Athenian Royalty Group Logo" class="h-20 w-auto">
                </div>

                <div class="w-full">
                    <div class="flex justify-between text-xs sm:text-sm font-medium text-gray-300 mb-2">
                        <div class="flex items-center space-x-1 text-orange-500">
                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            <span>Registration/Login</span>
                        </div>
                        <div>Email & Phone Verification</div>
                        <div>Identity Verification</div>
                    </div>
                    <div class="w-full h-2 bg-gray-700 rounded-full">
                        <div class="h-full bg-orange-500 rounded-full" style="width: 33%;"></div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">REGISTRATION</h2>
                <a href="{{ route('login') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors">LOGIN</a>
            </div>

            <!-- Success / Error Messages -->
            @include('layouts.errors')

            <!-- Form -->
            <form class="space-y-4" action="{{ route('submit.register') }}" method="post">
                @csrf

                <!-- Email -->
                <div>
                    <input type="email" name="email" placeholder="Email*" value="{{ old('email') }}"
                           class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('email') border-red-500 @enderror" required />
                    @error('email')
                    <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Name fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <input type="text" name="first_name" placeholder="First Name*" value="{{ old('first_name') }}"
                               class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('first_name') border-red-500 @enderror" required />
                        @error('first_name')
                        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="last_name" placeholder="Last Name*" value="{{ old('last_name') }}"
                               class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('last_name') border-red-500 @enderror" required />
                        @error('last_name')
                        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Phone fields -->
                <div class="relative">
                    <!--<div>-->
                    <!--    <input type="text" name="country_code" placeholder="Country Code*" value="{{ old('country_code', $user->country_code ?? '+1') }}"-->
                    <!--           class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('country_code') border-red-500 @enderror" required />-->
                    <!--    @error('country_code')-->
                    <!--    <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>-->
                    <!--    @enderror-->
                    <!--</div>-->
                    <div>
                        <input type="text" name="phone" placeholder="Phone*" value="{{ old('phone') }}"
                               class="w-full p-3 pr-10 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('phone') border-red-500 @enderror" required />
                        @error('phone')
                        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="relative">
                    <input type="password" name="password" placeholder="Password*" id="password"
                           value="{{ old('password') }}"
                           class="w-full p-3 pr-10 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('password') border-red-500 @enderror"
                           required />
                    <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white">
                        <!-- Eye icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    @error('password')
                    <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>
                    <ul class="text-sm mt-2 text-orange-400 space-y-1 ml-2">
                        <li>❗ contains at least one uppercase letter</li>
                        <li>❗ contains at least one digit character</li>
                        <li>❗ contains at least one special character</li>
                        <li>❗ contains at least 8 characters</li>
                    </ul>
                    @enderror

                </div>

                <!-- Password Confirmation -->
                <div class="relative">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password*" id="password_confirmation"
                           value="{{ old('password_confirmation') }}"
                           class="w-full p-3 pr-10 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                           required />
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white">
                        <!-- Eye icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>

                <!-- Address fields -->
                <!--<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">-->
                <!--    <div>-->
                <!--        <input type="text" name="country" placeholder="Country*" value="{{ old('country', 'United States') }}"-->
                <!--               class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('country') border-red-500 @enderror" required />-->
                <!--        @error('country')-->
                <!--        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>-->
                <!--        @enderror-->
                <!--    </div>-->
                <!--    <div>-->
                <!--        <input type="text" name="city" placeholder="City*" value="{{ old('city') }}"-->
                <!--               class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('city') border-red-500 @enderror" required />-->
                <!--        @error('city')-->
                <!--        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>-->
                <!--        @enderror-->
                <!--    </div>-->
                <!--    <div>-->
                <!--        <input type="text" name="state" placeholder="State*" value="{{ old('state') }}"-->
                <!--               class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('state') border-red-500 @enderror" required />-->
                <!--        @error('state')-->
                <!--        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>-->
                <!--        @enderror-->
                <!--    </div>-->
                <!--    <div>-->
                <!--        <input type="text" name="zip" placeholder="Zip*" value="{{ old('zip') }}"-->
                <!--               class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('zip') border-red-500 @enderror" required />-->
                <!--        @error('zip')-->
                <!--        <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>-->
                <!--        @enderror-->
                <!--    </div>-->
                <!--</div>-->

                <!-- Address -->
                <!--<div>-->
                <!--    <input type="text" name="address" placeholder="Address*" value="{{ old('address') }}"-->
                <!--           class="w-full p-3 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('address') border-red-500 @enderror" required />-->
                <!--    @error('address')-->
                <!--    <p class="text-sm text-red-500 mt-1 ml-1">{{ $message }}</p>-->
                <!--    @enderror-->
                <!--</div>-->

                <!-- Agreements -->
                <div class="space-y-3 text-sm text-gray-300 mt-4">
                    <label class="flex items-start space-x-2">
                        <input type="checkbox" name="terms" class="mt-1 rounded border-gray-600 bg-gray-700 text-orange-500 focus:ring-orange-500" {{ old('terms') ? 'checked' : '' }} required />
                        <span>I agree with the <a href="https://nycce.co/nycce-terms-of-service/" class="text-orange-500 hover:text-orange-400 underline transition-colors">Terms</a> </span>
                    </label>
                    <label class="flex items-start space-x-2">
                        <input type="checkbox" name="privacy" class="mt-1 rounded border-gray-600 bg-gray-700 text-orange-500 focus:ring-orange-500" {{ old('privacy') ? 'checked' : '' }} required />
                        <span>I agree with the <a href="https://nycce.co/privacy-policy/" class="text-orange-500 hover:text-orange-400 underline transition-colors">Privacy Policy</a></span>
                    </label>
                    <label class="flex items-start space-x-2">
                        <input type="checkbox" name="sharing" class="mt-1 rounded border-gray-600 bg-gray-700 text-orange-500 focus:ring-orange-500" {{ old('sharing') ? 'checked' : '' }} required />
                        <span>Details will be shared with 3rd parties for verification and transactions</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full mt-6 bg-orange-500 text-white py-3 rounded-md font-medium hover:bg-orange-600 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    NEXT
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, button) {
            const field = document.getElementById(fieldId);
            const icon = button.querySelector('svg');

            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.045 10.045 0 012.957-4.478M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18"/>
        `;
            } else {
                field.type = 'password';
                icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
            }
        }
    </script>

@endsection
