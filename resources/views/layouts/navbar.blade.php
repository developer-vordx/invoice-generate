@php
    $currentRoute = \Route::currentRouteName();
@endphp

<nav class="bg-black/90 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Athenian Royalty Group Logo" class="h-8 sm:h-10">
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard') }}"
                    class="text-sm font-medium px-3 py-2 rounded-md transition
                          {{ $currentRoute === 'dashboard' ? 'bg-orange-100 text-orange-600' : 'text-gray-200 hover:text-gray-900 hover:bg-gray-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('invoice.create') }}"
                    class="text-sm font-medium px-3 py-2 rounded-md transition
                          {{ $currentRoute === 'invoice.create' ? 'bg-orange-100 text-orange-600' : 'text-gray-200 hover:text-gray-900 hover:bg-gray-100' }}">
                    Create Payment
                </a>
                <a href="{{ route('user.verification') }}"
                    class="text-sm font-medium px-3 py-2 rounded-md transition
                          {{ $currentRoute === 'user.verification' ? 'bg-orange-100 text-orange-600' : 'text-gray-200 hover:text-gray-900 hover:bg-gray-100' }}">
                    ID Verification
                </a>
                <button id="logoutBtn"
                    class="text-sm font-medium px-3 py-2 rounded-md text-gray-200 hover:text-red-600 hover:bg-gray-100 transition">
                    Logout
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-1">
        <a href="{{ route('dashboard') }}"
            class="block py-2 text-sm font-medium
                  {{ $currentRoute === 'dashboard' ? 'text-orange-600' : 'text-gray-600 hover:text-gray-900' }}">
            Dashboard
        </a>
        <a href="{{ route('invoice.create') }}"
            class="block py-2 text-sm font-medium
                  {{ $currentRoute === 'invoice.create' ? 'text-orange-600' : 'text-gray-600 hover:text-gray-900' }}">
            Create Invoice
        </a>
        <a href="{{ route('user.verification') }}"
            class="block py-2 text-sm font-medium
                  {{ $currentRoute === 'user.verification' ? 'text-orange-600' : 'text-gray-600 hover:text-gray-900' }}">
            ID Verification
        </a>
        <button id="logoutBtnMobile" class="block py-2 text-sm text-red-600 font-medium">Logout</button>
    </div>

    <script>
        const menuBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</nav>


<!-- Hidden Logout Form -->
<form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
    @csrf
</form>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function() {
        document.getElementById('logoutForm').submit();
    });
</script>
