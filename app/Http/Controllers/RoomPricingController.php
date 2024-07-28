<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\RoomCategory;
use App\Models\Meal;
use App\Models\Pricing;
use App\Models\Supplement;


class RoomPricingController extends Controller
{
    public function create(Hotels $hotel)
    {
        // Fetch supplements assigned to the hotel
        $supplements = $hotel->supplements;
    
        // Fetch meals assigned to the hotel
        $meals = $hotel->meals;
    
        // Fetch existing pricing data for the hotel, if any
        $pricing = Pricing::where('hotel_id', $hotel->id)
            ->whereBetween('start_date', [now(), now()->addDays(30)]) // Adjust the date range as needed
            ->get()
            ->keyBy('supplement_id'); // Key by supplement_id to easily access it later
    
        // Pass the hotel, supplements, meals, and pricing to the view
        return view('admin.room_pricing.create', compact('hotel', 'supplements', 'meals', 'pricing'));
    }
    
    
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'Start_date' => 'nullable|date',
            'End_date' => 'nullable|date|after_or_equal:Start_date',
            'pricing.*.sgl' => 'nullable|numeric',
            'pricing.*.dbl' => 'nullable|numeric',
            'pricing.*.tpl' => 'nullable|numeric',
            'pricing.*.quartable' => 'nullable|numeric',
            'pricing.*.family' => 'nullable|numeric',
            'supplements.*.price' => 'nullable|numeric',
            'special_offer' => 'nullable|in:enable,disable' // Validate special_offer
        ]);
    
        // Extract values from the request
        $hotel_id = $request->input('hotel_id');
        $start_date = $request->input('Start_date');
        $end_date = $request->input('End_date');
        $special_offer = $request->input('special_offer', 'disable');
    
        // Store pricing information for meals
        foreach ($request->input('pricing', []) as $meal_id => $prices) {
            Pricing::updateOrCreate(
                [
                    'hotel_id' => $hotel_id,
                    'meals_id' => $meal_id, // Use meals_id
                    'Start_date' => $start_date,
                    'End_date' => $end_date,
                ],
                array_merge([
                    'type' => 'Standard',
                    'special_offer' => $special_offer
                ], $prices)
            );
        }
    
        // Prepare supplement prices and IDs as JSON
        $supplement_data = [];
        foreach ($request->input('supplements', []) as $supplement_id => $supplement) {
            $supplement_data[$supplement_id] = $supplement['price'];
        }
    
        // Store supplement prices
        Pricing::updateOrCreate(
            [
                'hotel_id' => $hotel_id,
                'Start_date' => $start_date,
                'End_date' => $end_date,
            ],
            [
                'type' => 'Standard',
                'special_offer' => $special_offer,
                'supplement_prices' => json_encode($supplement_data) // Save supplement prices as JSON
            ]
        );
    
        return redirect()->route('hotels.show', $hotel_id)
                         ->with('success', 'Room pricing added successfully.');
    }
    

    public function edit($hotelId, $pricingId)
    {
        $hotel = Hotels::findOrFail($hotelId);
        $pricing = HotelHasPricing::where('hotel_id', $hotelId)
                                  ->where('pricings_id', $pricingId)
                                  ->with('pricing', 'pricing.supplements') // Eager load relationships
                                  ->firstOrFail();
        $supplements = Supplement::all();
    
        return view('admin.room_pricing.edit', compact('hotel', 'pricing', 'supplements'));
    }

    public function update(Request $request, $hotelId, $pricingId)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'pricing' => 'required|array',
            'pricing.*.meal' => 'required|string|max:255',
            'pricing.*.sgl' => 'nullable|numeric',
            'pricing.*.dbl' => 'nullable|numeric',
            'pricing.*.tpl' => 'nullable|numeric',
            'pricing.*.quartable' => 'nullable|numeric',
            'pricing.*.family' => 'nullable|numeric',
            'supplements' => 'nullable|array',
            'supplements.*.supplement_id' => 'required|exists:supplements,id',
            'supplements.*.price' => 'required|numeric',
        ]);
    
        // Retrieve the hotel and pricing records
        $hotel = Hotels::findOrFail($hotelId);
        $pricing = HotelHasPricing::where('hotel_id', $hotelId)
                                  ->where('pricings_id', $pricingId)
                                  ->firstOrFail();
    
        $startPeriod = $validatedData['start_period'];
        $endPeriod = $validatedData['end_period'];
    
        // Retrieve or create the pricing entry
        $pricingEntry = Pricing::updateOrCreate(
            ['room_category_id' => $pricing->pricing->room_category_id],
            [
                'meal' => $validatedData['pricing'][$pricing->pricing->room_category_id]['meal'],
                'sgl' => $validatedData['pricing'][$pricing->pricing->room_category_id]['sgl'],
                'dbl' => $validatedData['pricing'][$pricing->pricing->room_category_id]['dbl'],
                'tpl' => $validatedData['pricing'][$pricing->pricing->room_category_id]['tpl'],
                'quartable' => $validatedData['pricing'][$pricing->pricing->room_category_id]['quartable'],
                'family' => $validatedData['pricing'][$pricing->pricing->room_category_id]['family'],
            ]
        );
    
        // Update or create hotel pricing data
        $pricing->update([
            'start_date' => $startPeriod,
            'end_date' => $endPeriod,
        ]);
    
      // Process supplements
      if (isset($validatedData['supplements'])) {
        foreach ($validatedData['supplements'] as $supplementData) {
            $existingSupplement = PricingHasSupplements::where([
                ['pricings_id', '=', $pricingEntry->id],
                ['supplements_id', '=', $supplementData['supplement_id']]
            ])->first();

            if ($existingSupplement) {
                // Update existing record
                $existingSupplement->update([
                    'supplements_start_date' => $startPeriod,
                    'supplements_end_date' => $endPeriod,
                    'supplements_price' => $supplementData['price']
                ]);
            }
            // If the record does not exist, it will not be created
        }
    }
    
        return redirect()->route('hotels.index')
            ->with('success', 'Pricing and supplements information updated successfully.');
    }
    public function destroy(Hotels $hotel, Pricing $pricing)
    {
        // Remove associated HotelHasPricing records
        HotelHasPricing::where('pricings_id', $pricing->id)->delete();
        
        // Remove associated SuplimentsHasPricing records
        PricingHasSupplements::where('pricings_id', $pricing->id)->delete();
        
        // Delete the pricing record
        $pricing->delete();
        
        // Redirect to the pricing index page with a success message
        return redirect()->route('hotels.index')
            ->with('success', 'Pricing deleted successfully.');
    }
    
}
