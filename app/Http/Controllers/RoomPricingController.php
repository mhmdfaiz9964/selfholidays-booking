<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\RoomCategory;
use App\Models\Pricing;
use App\Models\HotelHasPricing;
use App\Models\Supplement;
use App\Models\PricingHasSupplements;

class RoomPricingController extends Controller
{
    public function create(Hotels $hotel)
    {
        $roomCategories = RoomCategory::all();
        $supplements = Supplement::all();

        return view('admin.room_pricing.create', compact('hotel', 'roomCategories' ,'supplements'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
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

        $hotelId = $validatedData['hotel_id'];

        foreach ($validatedData['pricing'] as $roomCategoryId => $pricingData) {
            if ($roomCategoryId) {
                // Update or create pricing data
                $pricing = Pricing::updateOrCreate(
                    ['room_category_id' => $roomCategoryId],
                    [
                        'meal' => $pricingData['meal'],
                        'sgl' => $pricingData['sgl'],
                        'dbl' => $pricingData['dbl'],
                        'tpl' => $pricingData['tpl'],
                        'quartable' => $pricingData['quartable'],
                        'family' => $pricingData['family'],
                    ]
                );

                // Check if Pricing is created correctly
                if (!$pricing) {
                    return redirect()->back()->withErrors(['error' => 'Failed to create or update pricing']);
                }

                // Update or create hotel pricing data
                HotelHasPricing::updateOrCreate(
                    [
                        'hotel_id' => $hotelId,
                        'pricings_id' => $pricing->id
                    ],
                    [
                        'start_date' => $validatedData['start_period'],
                        'end_date' => $validatedData['end_period'],
                    ]
                );
            }
        }

        // Process supplements
        if (isset($validatedData['supplements'])) {
            foreach ($validatedData['supplements'] as $supplementData) {
                PricingHasSupplements::updateOrCreate(
                    [
                        'pricings_id' => $pricing->id, // Ensure this is the correct pricing ID
                        'supplements_id' => $supplementData['supplement_id']
                    ],
                    [
                        'supplements_start_date' => $validatedData['start_period'],
                        'supplements_end_date' => $validatedData['end_period'],
                        'supplements_price' => $supplementData['price']
                    ]
                );
            }
        }

        return redirect()->route('hotels.index')
            ->with('success', 'Pricing and supplements information stored successfully.');
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
        HotelHasPricing::where('pricing_id', $pricing->id)->delete();
    
        // Remove associated SuplimentsHasPricing records
        SuplimentsHasPricing::where('pricing_id', $pricing->id)->delete();
    
        // Delete the pricing record
        $pricing->delete();
    
        // Redirect to the pricing index page with a success message
        return redirect()->route('hotels.show', $hotel->id)
            ->with('success', 'Pricing deleted successfully.');
    }
}
