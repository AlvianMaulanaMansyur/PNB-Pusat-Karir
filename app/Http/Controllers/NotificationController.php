<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->dataEmployees;

        if (!$employee) {
            abort(403, 'Employee tidak ditemukan.');
        }

        // Tandai semua sebagai sudah dibaca
        $employee->unreadNotifications->markAsRead();

        $notifications = $employee->notifications;

        return view('jobseeker.notification', compact('notifications'));
    }
}
