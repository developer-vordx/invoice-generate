<aside class="w-56 bg-sidebar text-white flex flex-col min-h-screen">
    <!-- 🌐 Logo Section -->
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-exchange-alt text-white"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold">{{ config('app.name', 'ReconX') }}</h1>
                <p class="text-xs text-gray-400">Invoice Reconciliation</p>
            </div>
        </div>
    </div>

    <!-- 📋 Navigation Menu -->
    <nav class="flex-1 px-3 py-6 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-th-large w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Invoices -->
        <a href="{{ route('invoices.index') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('invoices.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-file-invoice w-5"></i>
            <span>Invoices</span>
        </a>

        <!-- Customers -->
        <a href="{{ route('customers.index') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-user w-5"></i>
            <span>Customers</span>
        </a>

        <!-- Products -->
        <a href="{{ route('products.index') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-box w-5"></i>
            <span>Products</span>
        </a>

        <!-- Reports -->
        <a href="{{ route('reports') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('reports') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-chart-bar w-5"></i>
            <span>Reports</span>
        </a>

        <!-- Users (Team Management) -->
        <a href="{{ route('users.index') ?? '#' }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-users w-5"></i>
            <span>Users</span>
        </a>

        <!-- Notifications -->
        <a href="{{ route('notifications.index') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('notifications.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-bell w-5"></i>
            <span>Notifications</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('settings.index') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-cog w-5"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- 💬 Help & Support -->
    <div class="p-3 border-t border-gray-700">
        <a href="{{ route('help') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition
                  {{ request()->routeIs('help') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-sidebar-hover' }}">
            <i class="fas fa-question-circle w-5"></i>
            <span>Help & Support</span>
        </a>
    </div>
</aside>
