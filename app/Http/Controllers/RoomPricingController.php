<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomPricing;
use App\Models\Hotels;
use App\Models\RoomCategory;

class RoomPricingController extends Controller
{
    public function create(Hotels $hotel)
    {
        $roomCategories = RoomCategory::all();
        return view('admin.room_pricing.create', compact('hotel', 'roomCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_category_id' => 'required|exists:room_categories,id',
            'room_only_price' => 'nullable|numeric',
            'room_only_start_date' => 'nullable|date',
            'room_only_end_date' => 'nullable|date',
            'bed_and_breakfast_price' => 'nullable|numeric',
            'bed_and_breakfast_start_date' => 'nullable|date',
            'bed_and_breakfast_end_date' => 'nullable|date',
            'half_board_price' => 'nullable|numeric',
            'half_board_start_date' => 'nullable|date',
            'half_board_end_date' => 'nullable|date',
            'full_board_price' => 'nullable|numeric',
            'full_board_start_date' => 'nullable|date',
            'full_board_end_date' => 'nullable|date',
            'all_inclusive_price' => 'nullable|numeric',
            'all_inclusive_start_date' => 'nullable|date',
            'all_inclusive_end_date' => 'nullable|date',
        ]);

        $roomPricing = new RoomPricing([
            'hotel_id' => $request->hotel_id,
            'room_category_id' => $request->room_category_id,
            'room_only_price' => $request->room_only_price,
            'room_only_start_date' => $request->room_only_start_date,
            'room_only_end_date' => $request->room_only_end_date,
            'bed_and_breakfast_price' => $request->bed_and_breakfast_price,
            'bed_and_breakfast_start_date' => $request->bed_and_breakfast_start_date,
            'bed_and_breakfast_end_date' => $request->bed_and_breakfast_end_date,
            'half_board_price' => $request->half_board_price,
            'half_board_start_date' => $request->half_board_start_date,
            'half_board_end_date' => $request->half_board_end_date,
            'full_board_price' => $request->full_board_price,
            'full_board_start_date' => $request->full_board_start_date,
            'full_board_end_date' => $request->full_board_end_date,
            'all_inclusive_price' => $request->all_inclusive_price,
            'all_inclusive_start_date' => $request->all_inclusive_start_date,
            'all_inclusive_end_date' => $request->all_inclusive_end_date,
        ]);

        $roomPricing->save();

        return redirect()->route('hotels.show', $request->hotel_id)
                         ->with('success', 'Room pricing added successfully.');
    }
}
