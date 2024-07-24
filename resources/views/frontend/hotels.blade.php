@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-8 text-center text-blue-700">Hotels</h1>

    <!-- Top Filters -->
    <form action="{{ route('hotel.index') }}" method="GET" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 bg-white shadow-lg rounded-lg">
            <div class="form-group">
                <label for="location" class="block text-gray-700 font-semibold">Location:</label>
                <select name="location" id="location" class="form-control block w-full mt-1 border rounded p-2">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="roomCategory" class="block text-gray-700 font-semibold">Room Category:</label>
                <select name="roomCategory" id="roomCategory" class="form-control block w-full mt-1 border rounded p-2">
                    <option value="">All Room Categories</option>
                    @foreach($roomCategories as $category)
                        <option value="{{ $category->id }}" {{ request('roomCategory') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="search" class="block text-gray-700 font-semibold">Search:</label>
                <input type="text" name="search" id="search" class="form-control block w-full mt-1 border rounded p-2" placeholder="Search Hotels" value="{{ request('search') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>

    <div class="flex flex-col lg:flex-row">
        <!-- Sidebar Filters -->
        <div class="lg:w-1/4 mb-6 lg:mb-0 lg:pr-4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h4 class="text-xl font-bold mb-4 text-blue-700">Filters</h4>

                <!-- Rating Filter -->
                <div class="mb-4">
                    <h5 class="text-lg font-semibold mb-2 text-gray-700">Rating</h5>
                    @for($i = 1; $i <= 5; $i++)
                        <a href="{{ route('hotel.index', array_merge(request()->all(), ['rating' => $i])) }}" class="block text-gray-700 mb-1 flex items-center">
                            <span class="mr-2">
                                @for ($star = 1; $star <= $i; $star++)
                                    <i class="fas fa-star text-yellow-500"></i>
                                @endfor
                                @for ($star = $i + 1; $star <= 5; $star++)
                                    <i class="far fa-star text-yellow-500"></i>
                                @endfor
                            </span>

                        </a>
                    @endfor
                </div>
                

                <!-- Price Range Filter -->
                <div class="mb-4">
                    <h5 class="text-lg font-semibold mb-2 text-gray-700">Price Range</h5>
                    <form action="{{ route('hotel.index') }}" method="GET">
                        <input type="hidden" name="location" value="{{ request('location') }}">
                        <input type="hidden" name="roomCategory" value="{{ request('roomCategory') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <label for="minPrice" class="block text-gray-700">Min Price:</label>
                        <input type="number" name="minPrice" id="minPrice" class="form-control block w-full mt-1 border rounded p-2" value="{{ request('minPrice') }}" placeholder="0">

                        <label for="maxPrice" class="block text-gray-700 mt-4">Max Price:</label>
                        <input type="number" name="maxPrice" id="maxPrice" class="form-control block w-full mt-1 border rounded p-2" value="{{ request('maxPrice') }}" placeholder="1000">

                        <button type="submit" class="btn btn-primary mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            <i class="fas fa-filter"></i> Apply
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hotels List -->
        <div class="lg:w-3/4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($hotels as $hotel)
                    <div class="card bg-white shadow-lg rounded-lg overflow-hidden flex flex-col">
                        @if($hotel->image)
                            <img src="{{ asset('storage/hotel_images/' . $hotel->image) }}" class="w-full h-48 object-cover" alt="{{ $hotel->name }}">
                        @endif
                        <div class="p-4 flex-grow flex flex-col">
                            <h5 class="text-xl font-bold mb-2 text-blue-700">{{ $hotel->name }}</h5>
                            <p class="text-gray-700 mb-2">{{ $hotel->description }}</p>
                            <div class="flex flex-wrap mb-4">
                                <!-- Location Badge -->
                                <p class="text-gray-700 mb-2 mr-4">
                                    <span class="inline-block bg-red-500 text-white px-2 py-1 rounded-full text-sm">
                                        <i class="fas fa-map-marker-alt"></i> {{ $hotel->location->name }}
                                    </span>
                                </p>
                                <!-- Rating -->
                                <p class="text-yellow-500 mb-2 flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            <!-- Display price if available -->
                            @if(isset($hotel->price))
                                <p class="text-gray-900 font-bold text-lg mb-4">
                                    <i class="fas fa-tag"></i> ${{ $hotel->price }}
                                </p>
                            @endif
                        </div>
                        <a href="{{ route('hotel.show', $hotel->id) }}" class="btn btn-primary px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            <i class="fas fa-bed mr-2"></i> Book Now
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $hotels->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
