<header class="bg-white border-b border-gray-200 px-8 py-4">
    <div class="flex items-center justify-between">
        <!-- Search -->
        <div class="flex-1 max-w-xl">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search invoices, payments, clients..."
                       class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>

        <!-- Profile -->
        <div class="flex items-center space-x-6">
            <button class="relative">
                <i class="fas fa-bell text-gray-600 text-xl"></i>
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
            </button>

            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'John Doe' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->is_admin ? 'Admin' : 'User' }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="ml-3 text-gray-600 hover:text-red-600">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
