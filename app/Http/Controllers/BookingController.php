<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\RoomCategory;
use App\Models\Location;
use App\Models\Pricing;
use App\Models\Supplement;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Define pagination parameters
        $perPage = 10; // Number of items per page
    
        // Build the query based on filters
        $query = Hotels::query();
    
        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }
    
        if ($request->has('roomCategory') && $request->roomCategory) {
            $query->whereHas('roomCategories', function($q) use ($request) {
                $q->where('id', $request->roomCategory);
            });
        }
    
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }
    
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        if ($request->has('minPrice')) {
            $query->where('price', '>=', $request->minPrice);
        }
    
        if ($request->has('maxPrice')) {
            $query->where('price', '<=', $request->maxPrice);
        }
    
        // Paginate the results
        $hotels = $query->paginate($perPage);
    
        // Fetch other required data for filters
        $roomCategories = RoomCategory::all();
        $locations = Location::all();
    
        return view('frontend.hotels', compact('hotels', 'roomCategories', 'locations'));
    }
    
    public function show(Hotels $hotel)
    {
        // Get related pricings for the hotel
        $pricings = $hotel->pricings; // This should be a collection or empty
        
        // Get all supplements
        $supplements = Supplement::all(); // This should be a collection or empty
    
        // Get related meals for the hotel
        $meals = $hotel->meals;
    
        // Get related room categories for the hotel
        $roomCategories = $hotel->roomCategories; // This should be a collection or empty
    
        return view('frontend.hotel-details', compact('hotel', 'pricings', 'meals', 'supplements', 'roomCategories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'meal_id' => 'required|exists:meals,id',
            'room_type' => 'required|string',
            'supplements' => 'required|string',
            'total_price' => 'required|numeric',
            'full_name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'adults' => 'required|integer',
            'children' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);
    
        Booking::create($validated);
    
        return response()->json(['message' => 'Booking confirmed!']);
    }
    
    public function calculatePrice(Request $request)
    {
        // Validate the request
        $request->validate([
            'meals_id' => 'required|exists:meals,id',
            'room_type' => 'required|in:sgl,dbl,tpl,Quartable,Family',
            'supplements' => 'nullable|array',
            'supplements.*' => 'exists:supplements,id',
        ]);

        // Get meal pricing details
        $mealId = $request->input('meals_id');
        $roomType = $request->input('room_type');
        $selectedSupplementIds = $request->input('supplements', []);

        // Fetch the meal pricing for the selected meal
        $pricing = Pricing::where('meals_id', $mealId)->first();

        if (!$pricing) {
            return response()->json(['error' => 'Pricing not found for the selected meal.'], 404);
        }

        // Get the price for the selected room type
        $roomTypePrice = $pricing[$roomType] ?? 0;

        // Get the price for selected supplements
        $totalSupplementPrice = 0;
        if (!empty($selectedSupplementIds)) {
            $supplements = Supplement::whereIn('id', $selectedSupplementIds)->get();
            foreach ($supplements as $supplement) {
                $totalSupplementPrice += $supplement->price;
            }
        }

        // Calculate total price
        $totalPrice = $roomTypePrice + $totalSupplementPrice;

        return response()->json([
            'room_type_price' => $roomTypePrice,
            'supplement_price' => $totalSupplementPrice,
            'total_price' => $totalPrice,
        ]);
    }

}
