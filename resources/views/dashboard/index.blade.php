@extends('layouts.auth.app')

@section('title', 'Dashboard - ' . config('app.name', 'ReconX'))

@section('content')
    <div class="w-full max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h1>

        {{-- ✅ Include stats --}}
        @include('dashboard.stats')

        {{-- ✅ Include charts --}}
        @include('dashboard.charts')
    </div>
@endsection
