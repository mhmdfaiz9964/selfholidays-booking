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
        <div class="mb-4">
            <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
            <select id="room_type" name="room_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="sgl">Single</option>
                <option value="dbl">Double</option>
                <option value="tpl">Triple</option>
                <option value="Quartable">Quartable</option>
                <option value="Family">Family</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label for="meal_type" class="block text-sm font-medium text-gray-700">Meal Type</label>
            <select id="meal_type" name="meal_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @foreach($meals as $meal)
                    <option value="{{ $meal->id }}">{{ $meal->title }}</option>
                @endforeach
            </select>
        </div>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Supplement
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($pricings as $pricing) <!-- Use $pricings instead of $mealPricings -->
                    @php
                        $supplementPrices = json_decode($pricing->supplement_prices, true);
                    @endphp
                    @if ($supplementPrices)
                        @foreach ($supplementPrices as $supplement_id => $price)
                            @php
                                $supplement = $supplements->firstWhere('id', $supplement_id);
                            @endphp
                            @if ($supplement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $supplement->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        USD {{ number_format($price, 2) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        {{-- <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                No supplements available
                            </td>
                        </tr> --}}
                    @endif
                @endforeach
            </tbody>
        </table>
        
        
        <div id="total_price" class="mb-4">
            <div id="totalPrice">Total Price: USD 0</div>
        </div>
        <!-- Book Now Button -->
    <button id="bookNowButton" type="button" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Book Now
    </button>

        
    </div>
</div>
<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Booking Details</h2>
        <div id="bookingDetails" class="mb-4">
            <form id="bookingForm">
                <div class="mb-4">
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="full_name" name="full_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile</label>
                    <input type="text" id="mobile" name="mobile" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="checkin_date" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                    <input type="date" id="checkin_date" name="checkin_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="checkout_date" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                    <input type="date" id="checkout_date" name="checkout_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="adults" class="block text-sm font-medium text-gray-700">Adults</label>
                    <input type="number" id="adults" name="adults" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="children" class="block text-sm font-medium text-gray-700">Children</label>
                    <input type="number" id="children" name="children" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
                <input type="hidden" id="hotel_id" name="hotel_id">
                <input type="hidden" id="meal_id" name="meal_id">
                <input type="hidden" id="room_type" name="room_type">
                <input type="hidden" id="supplements" name="supplements">
                <input type="hidden" id="total_price" name="total_price">
                <div class="flex justify-end">
                    <button type="button" id="submitBookingButton" class="bg-green-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Submit Booking
                    </button>
                </div>
            </form>
        </div>
        <div class="flex justify-end">
            <button id="closeModalButton" type="button" class="bg-red-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                Close
            </button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomTypeSelect = document.getElementById('room_type');
        const mealTypeSelect = document.getElementById('meal_type');
        const supplementCheckboxes = document.querySelectorAll('input[name="supplements[]"]');
        const totalPriceElement = document.getElementById('totalPrice');
        const bookNowButton = document.getElementById('bookNowButton');
        const bookingModal = document.getElementById('bookingModal');
        const closeModalButton = document.getElementById('closeModalButton');
        const bookingDetails = document.getElementById('bookingDetails');
        const bookingForm = document.getElementById('bookingForm');
        
        // Function to calculate price
        function calculatePrice() {
            const mealId = mealTypeSelect.value;
            const roomType = roomTypeSelect.value;
            const supplements = Array.from(supplementCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
    
            $.ajax({
                url: '{{ route('api.calculatePrice') }}',
                method: 'POST',
                data: {
                    meals_id: mealId,
                    room_type: roomType,
                    supplements: supplements,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    totalPriceElement.textContent = 'Total Price: USD ' + response.total_price;
                    // Store booking details in data attributes
                    bookNowButton.dataset.mealId = mealId;
                    bookNowButton.dataset.roomType = roomType;
                    bookNowButton.dataset.supplements = supplements.join(',');
                    bookNowButton.dataset.totalPrice = response.total_price;
                },
                error: function(xhr) {
                    console.error('Error calculating price:', xhr.responseText);
                }
            });
        }
    
        // Function to open modal
        function openModal() {
            const mealId = bookNowButton.dataset.mealId;
            const roomType = bookNowButton.dataset.roomType;
            const supplements = bookNowButton.dataset.supplements.split(',');
            const totalPrice = bookNowButton.dataset.totalPrice;
    
            bookingDetails.innerHTML = `
                <p><strong>Hotel ID:</strong> {{ $hotel->id }}</p>
                <p><strong>Meal ID:</strong> ${mealId}</p>
                <p><strong>Room Type:</strong> ${roomType}</p>
                <p><strong>Supplements:</strong> ${supplements.join(', ')}</p>
                <p><strong>Total Price:</strong> USD ${totalPrice}</p>
            `;
    
            bookingModal.classList.remove('hidden');
        }
    
        // Function to close modal
        function closeModal() {
            bookingModal.classList.add('hidden');
        }
    
        // Function to submit booking
        function submitBooking() {
            const formData = new FormData(bookingForm);
    
            $.ajax({
                url: '{{ route('booking.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Booking confirmed!');
                    closeModal();
                },
                error: function(xhr) {
                    console.error('Error submitting booking:', xhr.responseText);
                }
            });
        }
    
        // Add event listeners
        roomTypeSelect.addEventListener('change', calculatePrice);
        mealTypeSelect.addEventListener('change', calculatePrice);
        supplementCheckboxes.forEach(cb => cb.addEventListener('change', calculatePrice));
        bookNowButton.addEventListener('click', openModal);
        closeModalButton.addEventListener('click', closeModal);
        document.getElementById('submitBookingButton').addEventListener('click', submitBooking);
    });
    </script>
@endsection
