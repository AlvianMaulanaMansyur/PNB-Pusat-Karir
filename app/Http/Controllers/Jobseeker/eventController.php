<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class eventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('is_active', true)->orderBy('event_date', 'asc')
                      ->paginate(12);

        return view('jobseeker.event', compact('events'));
    }

    public function eventDetail($id)
    {
         $event = Event::findOrFail($id);

        // Jika event tidak aktif dan bukan admin, redirect atau tampilkan 404
        if (!$event->is_active) {
            abort(404);
        }

        return view('jobseeker.detailEvent', compact('event'));
    }
}
