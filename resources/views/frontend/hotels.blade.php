<!-- resources/views/frontend/hotels.blade.php -->

@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-8 text-center">Hotels</h1>

    <form action="{{ route('hotels.index') }}" method="GET" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label for="location" class="block text-gray-700">Location:</label>
                <select name="location" id="location" class="form-control block w-full mt-1 border rounded p-2">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="roomCategory" class="block text-gray-700">Room Category:</label>
                <select name="roomCategory" id="roomCategory" class="form-control block w-full mt-1 border rounded p-2">
                    <option value="">All Room Categories</option>
                    @foreach($roomCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($hotels as $hotel)
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                @if($hotel->image)
                    <img src="{{ asset('storage/hotel_images/' . $hotel->image) }}" class="w-full h-48 object-cover" alt="{{ $hotel->name }}">
                @endif
                <div class="p-4">
                    <h5 class="text-xl font-bold mb-2">{{ $hotel->name }}</h5>
                    <p class="text-gray-700 mb-2">{{ $hotel->description }}</p>
                    <p class="text-gray-700 mb-2"><i class="fas fa-map-marker-alt"></i> {{ $hotel->location->name }}</p>
                    <p class="text-gray-700 mb-2"><i class="fas fa-star"></i> {{ $hotel->rating }}</p>
                    <a href="#" class="btn btn-primary px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="fas fa-bed"></i> Book Now
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection