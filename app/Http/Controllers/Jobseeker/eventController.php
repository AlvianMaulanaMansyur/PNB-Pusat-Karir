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
        $events = Event::where('is_active', true)->latest('event_date')->get();

        return view('jobseeker.event', compact('events'));
    }
}
