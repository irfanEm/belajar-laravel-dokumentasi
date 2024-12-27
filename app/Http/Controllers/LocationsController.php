<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationsController extends Controller
{
    public function index(): Response
    {
        $locations = Location::all();
        return response()->view('locations.index', ['locations' => $locations]);
    }

    public function show(Location $location): Response
    {
        return response()->view('locations.show', ['location' => $location]);
    }
}
