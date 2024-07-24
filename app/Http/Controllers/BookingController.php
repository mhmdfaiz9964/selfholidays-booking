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
    
        // Optionally, get all supplements
        $supplements = Supplement::all(); // This should be a collection or empty
    
        // Get related room categories for the hotel
        $roomCategories = $hotel->roomCategories; // This should be a collection or empty
    
        return view('frontend.hotel-details', compact('hotel', 'pricings', 'supplements', 'roomCategories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'room_type' => 'required|exists:room_categories,id',
            'number_of_children' => 'nullable|integer|min:0',
            'number_of_adults' => 'required|integer|min:1',
            'supplements' => 'nullable|array',
            'supplements.*' => 'exists:supplements,id',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'message' => 'nullable|string',
        ]);

        // Fetch the selected room category
        $roomCategory = RoomCategory::find($request->room_type);

        if (!$roomCategory) {
            return back()->withErrors(['room_type' => 'Selected room type is not valid.']);
        }

        // Fetch selected supplements
        $supplementIds = $request->input('supplements', []);
        $supplements = Supplement::whereIn('id', $supplementIds)->get();
        $supplementTotal = $supplements->sum('price');

        // Calculate the total price
        $numberOfDays = (new \DateTime($request->checkout_date))->diff(new \DateTime($request->checkin_date))->days;
        $roomCategoryPrice = $roomCategory->price_per_night; // Assuming price_per_night is a field in RoomCategory
        $totalPrice = ($roomCategoryPrice + $supplementTotal) * $numberOfDays;

        // Create the booking
        $booking = Booking::create([
            'hotel_id' => $request->hotel_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'room_type_id' => $request->room_type,
            'number_of_children' => $request->number_of_children,
            'number_of_adults' => $request->number_of_adults,
            'supplements' => json_encode($supplementIds),
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'price' => $totalPrice,
            'message' => $request->message,
        ]);

        return redirect()->route('booking.success')->with('success', 'Booking created successfully.');
    }

    public function calculatePrice(Request $request)
{
    $request->validate([
        'room_type' => 'required|exists:room_categories,id',
        'checkin_date' => 'required|date|after_or_equal:today',
        'checkout_date' => 'required|date|after:checkin_date',
        'supplements' => 'nullable|array',
        'supplements.*' => 'exists:supplements,id',
    ]);

    // Fetch the selected room category
    $roomCategory = RoomCategory::find($request->room_type);

    if (!$roomCategory) {
        return response()->json(['error' => 'Selected room type is not valid.'], 400);
    }

    // Fetch selected supplements
    $supplementIds = $request->input('supplements', []);
    $supplements = Supplement::whereIn('id', $supplementIds)->get();
    $supplementTotal = $supplements->sum('price');

    // Calculate the total price
    $numberOfDays = (new \DateTime($request->checkout_date))->diff(new \DateTime($request->checkin_date))->days;
    $roomCategoryPrice = $roomCategory->price_per_night; // Assuming price_per_night is a field in RoomCategory
    $totalPrice = ($roomCategoryPrice + $supplementTotal) * $numberOfDays;

    return response()->json(['total_price' => $totalPrice]);
}

}
