<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DetailAkunController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            // Buat data dummy agar halaman tetap bisa ditampilkan
            $user = (object) [
                'id' => 0,
                'name' => '-',
                'email' => '-',
                'created_at' => now(),
                'status_verifikasi' => null,
            ];
        }

        return view('admin.DetailAkun', ['user' => $user]);
    }
}
