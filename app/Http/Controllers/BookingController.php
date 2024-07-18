<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\RoomCategory;
use App\Models\Location;

class BookingController extends Controller
{
    public function index()
    {
        $hotels = Hotels::all();
        $roomCategories = RoomCategory::all();
        $locations = Location::all();

        return view('frontend.hotels', compact('hotels', 'roomCategories', 'locations'));
    }
}
