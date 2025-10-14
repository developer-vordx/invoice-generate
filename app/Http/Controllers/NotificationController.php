<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    // 🧭 Show all notifications (global)
    public function index()
    {
        try {
            $notifications = DatabaseNotification::latest()->paginate(10);
            return view('notifications.index', compact('notifications'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load notifications: ' . $e->getMessage());
        }
    }

    // ✅ Mark all as read
    public function markAllRead()
    {
        try {
            DatabaseNotification::whereNull('read_at')->update(['read_at' => now()]);
            return back()->with('success', 'All notifications marked as read.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark notifications as read: ' . $e->getMessage());
        }
    }
}
