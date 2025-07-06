<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function AdminDashboard()
    {
        $users = User::all(); // Atau bisa gunakan pagination, filter, dll
        return view('admin.dashboard', compact('users'));
    }
}
