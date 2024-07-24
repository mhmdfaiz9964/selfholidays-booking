<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\RoomCategory;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use App\Models\Supplement;


class HotelController extends Controller
{
    /**
     * Display a listing of the hotels.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotels::latest()->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new hotel.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        $roomCategories = RoomCategory::all();
        return view('admin.hotels.create', compact('locations', 'roomCategories'));
    }

    /**
     * Store a newly created hotel in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'location_id' => 'required|exists:locations,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB max size for image
            'group_of_company' => 'nullable|string',
            'sales_manager_name' => 'nullable|string',
            'sales_manager_contact' => 'nullable|string',
            'room_category_id' => 'nullable|array',
            'room_category_id.*' => 'exists:room_categories,id',
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/hotel_images', $imageName);
        }

        // Create hotel
        $hotel = new Hotels();
        $hotel->name = $request->name;
        $hotel->rating = $request->rating;
        $hotel->location_id = $request->location_id;
        $hotel->description = $request->description;
        $hotel->image = $imageName;
        $hotel->group_of_company = $request->group_of_company;
        $hotel->sales_manager_name = $request->sales_manager_name;
        $hotel->sales_manager_contact = $request->sales_manager_contact;
        $hotel->save();

        // Attach room categories
        if ($request->has('room_category_id')) {
            $hotel->roomCategories()->attach($request->room_category_id);
        }

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel created successfully.');
    }

    /**
     * Show the form for editing the specified hotel.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotels $hotel)
    {
        $locations = Location::all();
        $roomCategories = RoomCategory::all();
        $hotel->load('roomCategories'); // Load room categories for the hotel
        return view('admin.hotels.edit', compact('hotel', 'locations', 'roomCategories'));
    }

    /**
     * Update the specified hotel in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotels $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'location_id' => 'required|exists:locations,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB max size for image
            'group_of_company' => 'nullable|string',
            'sales_manager_name' => 'nullable|string',
            'sales_manager_contact' => 'nullable|string',
            'room_category_id' => 'nullable|array',
            'room_category_id.*' => 'exists:room_categories,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($hotel->image && Storage::exists('public/hotel_images/' . $hotel->image)) {
                Storage::delete('public/hotel_images/' . $hotel->image);
            }
            // Upload new image
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/hotel_images', $imageName);
            $hotel->image = $imageName;
        }

        // Update hotel
        $hotel->name = $request->name;
        $hotel->rating = $request->rating;
        $hotel->location_id = $request->location_id;
        $hotel->description = $request->description;
        $hotel->group_of_company = $request->group_of_company;
        $hotel->sales_manager_name = $request->sales_manager_name;
        $hotel->sales_manager_contact = $request->sales_manager_contact;
        $hotel->save();

        // Sync room categories
        if ($request->has('room_category_id')) {
            $hotel->roomCategories()->sync($request->room_category_id);
        } else {
            $hotel->roomCategories()->detach(); // Detach all room categories if none provided
        }

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified hotel from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotels $hotel)
    {
        // Delete hotel image if exists
        if ($hotel->image && Storage::exists('public/hotel_images/' . $hotel->image)) {
            Storage::delete('public/hotel_images/' . $hotel->image);
        }

        $hotel->delete();

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel deleted successfully.');
    }

    public function show(Hotels $hotel)
    {
        // Eager load relationships
        $hotel->load('location', 'roomCategories', 'hotelHasPricing', 'pricingHasSupplements.supplement');
    
        // Get all pricing records associated with the hotel
        $pricings = $hotel->hotelHasPricing->map(function($hotelPricing) {
            return $hotelPricing->pricing; // Fetch associated Pricing model
        });
    
        return view('admin.hotels.view', compact('hotel', 'pricings'));
    }

    public function supplementsStore(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'title' => 'required|string|max:255',
        ]);

        Supplement::create([
            'hotel_id' => $request->hotel_id,
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Supplement added successfully.');
    }
    
}
