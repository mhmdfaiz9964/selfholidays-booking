@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hotel Header -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex flex-col lg:flex-row">
            <!-- Hotel Image -->
            <div class="lg:w-1/2 mb-4 lg:mb-0">
                @if($hotel->image)
                    <img src="{{ asset('storage/hotel_images/' . $hotel->image) }}" class="w-full h-64 lg:h-96 object-cover rounded-lg shadow-md" alt="{{ $hotel->name }}">
                @else
                    <img src="https://via.placeholder.com/600x400" class="w-full h-64 lg:h-96 object-cover rounded-lg shadow-md" alt="Placeholder Image">
                @endif
            </div>

            <!-- Hotel Details -->
            <div class="lg:w-1/2 lg:pl-8">
                <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ $hotel->name }}</h1>
                <p class="text-gray-700 text-lg mb-4">{{ $hotel->description }}</p>
                <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $hotel->location->name ?? 'N/A' }}</p>
                <div class="text-yellow-500 mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $hotel->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-gray-600 mb-2"><strong>Email:</strong> {{ $hotel->email }}</p>
                <p class="text-gray-600 mb-2"><strong>Phone:</strong> {{ $hotel->phone }}</p>
                <p class="text-gray-600 mb-2"><strong>Group of Company:</strong> {{ $hotel->group_of_company }}</p>
                <p class="text-gray-600 mb-2"><strong>Sales Manager:</strong> {{ $hotel->sales_manager_name }}</p>
                <p class="text-gray-600 mb-2"><strong>Sales Manager Contact:</strong> {{ $hotel->sales_manager_contact }}</p>
            </div>
        </div>
        
        <!-- Room Categories -->
        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Room Categories</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($roomCategories as $category)
                    <span class="bg-blue-200 text-blue-800 px-4 py-2 rounded-full text-sm">{{ $category->title }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Booking Form -->
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-blue-700 mb-6">Book Your Stay</h2>
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <!-- Full Name -->
            <div class="mb-6">
                <label for="full_name" class="block text-gray-700 text-sm font-medium mb-2">
                    <i class="fas fa-user text-blue-500 mr-2"></i> Full Name
                </label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                    <i class="fas fa-envelope text-blue-500 mr-2"></i> Email Address
                </label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>

            <!-- Phone Number -->
            <div class="mb-6">
                <label for="phone_number" class="block text-gray-700 text-sm font-medium mb-2">
                    <i class="fas fa-phone text-blue-500 mr-2"></i> Phone Number
                </label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your phone number" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>

            <!-- Hotel Name (Disabled) -->
            <div class="mb-6">
                <label for="hotel_name" class="block text-gray-700 text-sm font-medium mb-2">
                    <i class="fas fa-hotel text-blue-500 mr-2"></i> Hotel Name
                </label>
                <input type="text" id="hotel_name" value="{{ $hotel->name }}" class="form-input w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed" disabled>
            </div>

            <!-- Room Type -->
            <div class="mb-4 flex items-center">
                <i class="fas fa-bed text-gray-600 mr-2"></i>
                <select id="room_type" name="room_type" class="form-select w-full">
                    @foreach($roomCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Number of Children -->
            <div class="mb-6">
                <label for="children" class="block text-gray-700 text-sm font-medium mb-2">
                    <i class="fas fa-child text-blue-500 mr-2"></i> Number of Children
                </label>
                <input type="number" id="children" name="children" placeholder="Enter number of children" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" min="0" value="0">
            </div>

            <!-- Number of Adults -->
            <div class="mb-6">
                <label for="adults" class="block text-gray-700 text-sm font-medium mb-2">
                    <i class="fas fa-user-plus text-blue-500 mr-2"></i> Number of Adults
                </label>
                <input type="number" id="adults" name="adults" placeholder="Enter number of adults" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" min="1" value="1">
            </div>

            <!-- Supplements -->
            <div class="mb-4">
                <h3 class="text-lg font-bold mb-2">Select Supplements</h3>
                @foreach($supplements as $supplement)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="supplements[]" value="{{ $supplement->id }}" id="supplement-{{ $supplement->id }}" class="mr-2">
                        <label for="supplement-{{ $supplement->id }}" class="text-gray-700">{{ $supplement->title }} - ${{ $supplement->price }}</label>
                    </div>
                @endforeach
            </div>
            <div id="total_price" class="mb-4 text-lg font-bold">Total Price: $0.00</div>


            <!-- Submit Button -->
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit Booking</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    function calculatePrice() {
        var roomType = $('#room_type').val();
        var checkinDate = $('#checkin_date').val();
        var checkoutDate = $('#checkout_date').val();
        var supplements = [];
        
        $('input[name="supplements[]"]:checked').each(function() {
            supplements.push($(this).val());
        });

        $.ajax({
            url: '{{ route('calculate.price') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                room_type: roomType,
                checkin_date: checkinDate,
                checkout_date: checkoutDate,
                supplements: supplements
            },
            success: function(response) {
                $('#total_price').text('Total Price: $' + response.total_price.toFixed(2));
            },
            error: function(response) {
                $('#total_price').text('Error calculating price.');
            }
        });
    }

    $('#room_type, #checkin_date, #checkout_date').change(calculatePrice);
    $('input[name="supplements[]"]').change(calculatePrice);
});
</script>
@endsection
