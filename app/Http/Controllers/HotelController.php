<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\RoomCategory;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Meal;
use App\Models\Supplement;
use App\Models\Pricing;


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
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'sales_manager_name' => 'nullable|string',
            'sales_manager_contact' => 'nullable|string',
            'room_category_id' => 'nullable|array',
            'room_category_id.*' => 'exists:room_categories,id',
            'pdf_urls.*' => 'file|mimes:pdf|max:5048', // 2MB max size for PDFs
        ]);
    
        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/hotel_images', $imageName);
        }
    
        // Handle PDF uploads
        $pdfUrls = [];
        if ($request->hasFile('pdf_urls')) {
            foreach ($request->file('pdf_urls') as $pdf) {
                $pdfName = time() . '_' . $pdf->getClientOriginalName();
                $pdf->storeAs('public/hotel_pdfs', $pdfName);
                $pdfUrls[] = 'hotel_pdfs/' . $pdfName;
            }
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
        $hotel->email = $request->email;
        $hotel->phone = $request->phone;
        $hotel->pdf_urls = json_encode($pdfUrls); // Save PDFs as JSON
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
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
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
        $hotel->email = $request->email;
        $hotel->phone = $request->phone;
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
        // Fetch supplements and meals associated with the hotel
        $supplements = $hotel->supplements;
        $meals = $hotel->meals;
        
        // Fetch pricing information for meals specific to this hotel
        $mealPricings = Pricing::where('hotel_id', $hotel->id)
            ->whereNotNull('meals_id') // Ensure only records with meals_id are considered
            ->get();
        
        // Fetch pricing information for supplements specific to this hotel
        $supplementPricings = Pricing::where('hotel_id', $hotel->id)
            ->whereNotNull('supplement_prices') // Ensure only records with supplement_prices are considered
            ->get();
        
        return view('admin.hotels.view', compact('hotel', 'supplements', 'meals', 'mealPricings', 'supplementPricings'));
    }
    
    
    public function fetchSupplements($hotelId)
    {
        // Fetch the hotel by ID
        $hotel = Hotels::find($hotelId);
    
        // Check if the hotel exists
        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found.'], 404);
        }
    
        // Fetch supplements assigned to the hotel
        $supplements = $hotel->supplements;
    
        // Return the supplements as JSON
        return response()->json($supplements);
    }
    

    // Store a new supplement
    public function storeSupplement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'hotel_id' => 'required|integer|exists:hotels,id', // Assuming you need a hotel_id
        ]);

        $supplement = new Supplement();
        $supplement->title = $request->title;
        $supplement->hotel_id = $request->hotel_id; // Assuming hotel_id is required
        $supplement->save();

        return response()->json(['success' => 'Supplement created successfully.']);
    }

    // Delete a supplement
    public function destroySupplement($id)
    {
        try {
            $supplement = Supplement::findOrFail($id);
            $supplement->delete();
            return response()->json(['success' => 'Supplement deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    // Fetch all meals
    public function fetchMeals()
    {
        $meals = Meal::all();
        return response()->json($meals);
    }

    // Store a new meal
    public function storeMeal(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'hotel_id' => 'required|integer|exists:hotels,id', // Assuming you need a hotel_id
        ]);

        $meal = new Meal();
        $meal->title = $request->title;
        $meal->hotel_id = $request->hotel_id; // Assuming hotel_id is required
        $meal->save();

        return response()->json(['success' => 'Meal created successfully.']);
    }

    // Delete a meal
    public function destroyMeal($id)
    {
        try {
            $meal = Meal::findOrFail($id);
            $meal->delete();
            return response()->json(['success' => 'Meal deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
