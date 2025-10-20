<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $employeeId = Auth::id();

        $notifications = Notification::where('employee_id', $employeeId)
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('employee_id', Auth::id())
            ->firstOrFail();

        $notif->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi telah dibaca.');
    }
}
