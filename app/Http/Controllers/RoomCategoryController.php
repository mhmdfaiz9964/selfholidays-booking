<?php

namespace App\Http\Controllers;

use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomCategoryController extends Controller
{
    /**
     * Display a listing of the room categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomCategories = RoomCategory::all();
        return view('admin.room_categories.index', compact('roomCategories'));
    }

    /**
     * Show the form for creating a new room category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room_categories.create');
    }

    /**
     * Store a newly created room category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        // Create room category
        RoomCategory::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect()->route('room-categories.index')
            ->with('success', 'Room category created successfully.');
    }

    /**
     * Show the form for editing the specified room category.
     *
     * @param  \App\Models\RoomCategory  $roomCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomCategory $roomCategory)
    {
        return view('admin.room_categories.edit', compact('roomCategory'));
    }

    /**
     * Update the specified room category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomCategory  $roomCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomCategory $roomCategory)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle image update if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            // Delete old image if exists
            if ($roomCategory->image) {
                unlink(public_path('images/' . $roomCategory->image));
            }
            $roomCategory->image = $imageName;
        }

        // Update room category
        $roomCategory->title = $request->title;
        $roomCategory->description = $request->description;
        $roomCategory->save();

        return redirect()->route('room-categories.index')
            ->with('success', 'Room category updated successfully.');
    }

    /**
     * Remove the specified room category from storage.
     *
     * @param  \App\Models\RoomCategory  $roomCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomCategory $roomCategory)
    {
        // Delete image if exists
        if ($roomCategory->image) {
            unlink(public_path('images/' . $roomCategory->image));
        }

        // Delete room category
        $roomCategory->delete();

        return redirect()->route('room-categories.index')
            ->with('success', 'Room category deleted successfully.');
    }
}
