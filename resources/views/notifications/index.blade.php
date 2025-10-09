@extends('layouts.auth.app')

@section('title', 'Notifications - ReconX')

@section('content')
    <!-- Page Header -->
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Notifications</h2>

        <button id="markAllReadBtn" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-check-double mr-2"></i>Mark All as Read
        </button>
    </header>

    <!-- Notifications List -->
    <main class="p-8">
        <div class="bg-white rounded-xl shadow border border-gray-100 divide-y">
            @forelse($notifications as $notification)
                <div class="flex justify-between items-start p-5 hover:bg-gray-50 transition">
                    <div class="flex items-start space-x-3">
                        <!-- Icon -->
                        <div class="p-2 rounded-full
                            @if($notification->type === 'invoice') bg-blue-100 text-blue-600
                            @elseif($notification->type === 'user') bg-green-100 text-green-600
                            @elseif($notification->type === 'system') bg-purple-100 text-purple-600
                            @else bg-gray-100 text-gray-600 @endif">
                            <i class="fas
                                @if($notification->type === 'invoice') fa-file-invoice-dollar
                                @elseif($notification->type === 'user') fa-user-plus
                                @elseif($notification->type === 'system') fa-cog
                                @else fa-bell @endif"></i>
                        </div>

                        <!-- Content -->
                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $notification->title ?? 'System Notification' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $notification->message ?? 'No details available.' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <!-- Status -->
                    @if(!$notification->is_read)
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-2"></span>
                    @endif
                </div>
            @empty
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-bell-slash text-3xl mb-3"></i>
                    <p>No notifications yet.</p>
                </div>
            @endforelse
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mark all as read
        document.getElementById('markAllReadBtn').addEventListener('click', () => {
            fetch('{{ route('notifications.markAllRead') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(res => res.json()).then(data => {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                if (data.success) location.reload();
            });
        });
    </script>
@endsection
