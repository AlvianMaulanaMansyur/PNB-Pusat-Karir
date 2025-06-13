<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->dataEmployees; // Ambil dari relasi user → employee

        if (!$employee) {
            abort(403, 'Employee tidak ditemukan.');
        }

        $notifications = $employee->notifications;

        return view('jobseeker.notification', compact('notifications'));
    }
}
