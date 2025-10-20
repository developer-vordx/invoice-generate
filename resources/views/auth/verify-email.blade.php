@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen p-4">
        <div class="bg-black/90 w-full max-w-md rounded-2xl shadow-xl p-6 sm:p-10">

            <!-- Logo & Progress Bar -->
            <div class="flex flex-col items-center w-full mb-8">
                <!-- Logo -->
                <div class="mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Athenian Royalty Group Logo" class="h-20 w-auto">
                </div>

                <div class="w-full">
                    <div class="flex justify-between text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        <div class="flex items-center space-x-1 text-orange-600">
                            <div class="w-2 h-2 bg-orange-600 rounded-full"></div>
                            <span>Registration</span>
                        </div>
                        <div class="flex items-center space-x-1 text-orange-600" >
                            <div class="w-2 h-2 bg-orange-600 rounded-full"></div>
                            <span>Email Verification</span>
                        </div>
                        <div class="text-white">Identity Verification</div>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-orange-500 rounded-full" style="width: 66%;"></div>
                    </div>
                </div>
            </div>

            @include('layouts.errors')

            <h2 class="text-2xl font-bold text-center text-white mb-4">Verify Your Email</h2>
            <p class="text-center text-white mb-6">Enter the 6-digit code sent to your email.</p>

            <form method="POST" action="/" class="space-y-4">
                @csrf
                <input type="text" name="otp" maxlength="6" required
                       class="w-full p-3 border border-gray-300 rounded-md text-center tracking-widest text-xl"
                       placeholder="Enter OTP" />

                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-md">
                    Verify
                </button>
            </form>

            <div class="text-center text-sm text-gray-600 mt-4">
                    Didn't receive the code?
                    <button type="button" id="resend-button" class="text-blue-600 hover:underline ml-1">Resend</button>
                    <div id="resend-message" class="mt-2 text-sm"></div>
            </div>

        </div>
</div>

<script>
    document.getElementById('resend-button').addEventListener('click', function () {
        const resendButton = this;
        const messageBox = document.getElementById('resend-message');

        resendButton.disabled = true;
        messageBox.textContent = 'Sending...';
        messageBox.className = 'mt-2 text-sm text-gray-500';

        fetch("{{ route('login') }}", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
            .then(res => res.json())
            .then(data => {
                resendButton.disabled = false;
                messageBox.textContent = data.message;
                messageBox.className = 'mt-2 text-sm ' + (data.success ? 'text-green-600' : 'text-red-600');
            })
            .catch(error => {
                resendButton.disabled = false;
                messageBox.textContent = 'Something went wrong. Please try again.';
                messageBox.className = 'mt-2 text-sm text-red-600';
                console.error(error);
            });
    });
</script>

@endsection
