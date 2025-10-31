<header class="bg-white border-b border-gray-200 px-8 py-4">
    <div class="flex items-center justify-between">

        <!-- 🔍 Search -->
        <div class="flex-1 max-w-xl">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                       placeholder="Search invoices, payments, clients..."
                       class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>

        <!-- 🔔 Notifications + Profile -->
        <div class="flex items-center space-x-6">

            <!-- Notifications Dropdown -->
            <div class="relative">
                <button id="notificationBtn" class="relative focus:outline-none">
                    <i class="fas fa-bell text-gray-600 text-xl"></i>

                    @php
                        $unreadCount = \Illuminate\Notifications\DatabaseNotification::whereNull('read_at')->count();
                    @endphp

                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>

                <!-- Dropdown -->
                <div id="notificationDropdown"
                     class="hidden absolute right-0 mt-3 w-96 bg-white shadow-lg rounded-xl border border-gray-100 z-50">
                    <div class="p-4 border-b flex justify-between items-center">
                        <h4 class="text-sm font-semibold text-gray-800">Notifications</h4>
                        <a href="{{ route('notifications.index') }}"
                           class="text-xs text-blue-600 hover:underline">View all</a>
                    </div>

                    <div class="max-h-96 overflow-y-auto" id="notificationList">
                        @php
                            $notifications = \Illuminate\Notifications\DatabaseNotification::latest()->take(5)->get();
                        @endphp

                        @forelse($notifications as $notification)
                            @php
                                $data = $notification->data;
                            @endphp

                            <a href="{{ $data['url'] ?? '#' }}"
                               target="_blank"
                               class="block p-4 hover:bg-gray-50 border-b transition {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="text-sm font-semibold text-gray-800">
                                            {{ $data['title'] ?? 'Notification' }}
                                        </h5>
                                        <p class="text-xs text-gray-600 mt-1">
                                            {{ $data['message'] ?? '' }}
                                        </p>
                                    </div>
                                    @if(isset($data['status']))
                                        <span class="text-[10px] uppercase px-2 py-1 rounded-full
                                            {{ $data['status'] === 'complete' ? 'bg-green-100 text-green-700' :
                                               ($data['status'] === 'incomplete' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-gray-500 block mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </a>
                        @empty
                            <p class="text-center py-4 text-gray-500 text-sm">No notifications found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 👤 Profile -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->first_name ?? 'John Doe' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role ? 'Admin' : 'User' }}</p>
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

    <!-- JS for dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('notificationBtn');
            const dropdown = document.getElementById('notificationDropdown');

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', () => dropdown.classList.add('hidden'));
        });
    </script>
</header>
