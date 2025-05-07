<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function getCountries (Request $request)
    {
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');
        $countries = $response->json()['data'];
        return response()->json($countries);

    }

    public function getCities (Request $request)
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', [
            'country' => $request->country
        ]);

        return response()->json($response->json()['data']);
    }


}
