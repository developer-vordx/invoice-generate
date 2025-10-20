@extends('layouts.app')

@section('title', 'Verify Your Email Address')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-6 py-12">
        <div class="max-w-md w-full bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Verify Your Email</h1>
                <p class="text-gray-500 mt-2">
                    Before proceeding, please check your email for a verification link.
                </p>
            </div>

            {{-- Success message if link re-sent --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600 font-semibold">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-md transition">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                        Log Out
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <div class="mt-8 text-center text-xs text-gray-400">
                Didn’t receive an email? Check your spam folder or click “Resend”.
            </div>
        </div>
    </div>
@endsection
