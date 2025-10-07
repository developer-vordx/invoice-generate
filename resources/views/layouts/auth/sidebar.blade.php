<aside class="w-56 bg-sidebar text-white flex flex-col">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                <i class="fas fa-exchange-alt text-white"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold">{{ config('app.name', 'ReconX') }}</h1>
                <p class="text-xs text-gray-400">Invoice Reconciliation</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-6 space-y-1">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-primary rounded-lg text-white">
            <i class="fas fa-th-large w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('invoices.index') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-file-invoice w-5"></i>
            <span>Invoices</span>
        </a>

        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-credit-card w-5"></i>
            <span>Payments</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-sync-alt w-5"></i>
            <span>Reconciliation</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-chart-bar w-5"></i>
            <span>Reports</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-users w-5"></i>
            <span>Users</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-bell w-5"></i>
            <span>Notifications</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-cog w-5"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Help -->
    <div class="p-3">
        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-sidebar-hover rounded-lg transition">
            <i class="fas fa-question-circle w-5"></i>
            <span>Help & Support</span>
        </a>
    </div>
</aside>
