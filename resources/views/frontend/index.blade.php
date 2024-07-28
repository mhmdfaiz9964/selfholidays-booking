@extends('frontend.layouts.app')

@section('content')
<div class="relative h-screen md:h-70vh bg-cover bg-center" style="background-image: url('https://media.cnn.com/api/v1/images/stellar/prod/210429125139-address-beach-resort-zeta-77-rooftop-pool-1.jpg');">
    <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm"></div>
    <div class="relative flex flex-col md:flex-row items-center justify-between h-full text-left px-8 md:px-16">
        <div class="text-white mb-8 md:mb-0 md:w-1/2 flex flex-col items-start">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 pt-6">Discover A Brand Luxurious Hotel</h1>
            <p class="text-lg mb-6">Book the perfect Wander with inspiring views, modern workstations, restful beds, hotel-grade cleaning, and 24/7 concierge service. It's a vacation home, but better.</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <a href="#" class="px-8 py-3 bg-orange-500 text-white border border-white rounded hover:bg-orange-600 transition">OUR ROOMS</a>
                <a href="{{ route('hotels.index') }}" class="px-8 py-3 bg-white text-black rounded hover:bg-gray-200 transition">BOOK A ROOM</a>                
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center md:justify-center">
            <img src="https://media.cnn.com/api/v1/images/stellar/prod/160523150838-6-intercontinental-danang.jpg" alt="Hotel Image" class="w-full md:w-auto h-auto border border-gray-300 shadow-lg rounded-lg">
        </div>
    </div>
</div>
<style>
    /* Adjustments for mobile view */
@media (max-width: 768px) {
    /* Ensure flex items stack vertically */
    .flex {
        display: block;
    }
    
    /* Adjust height of screen */
    .h-screen {
        height: 100vh; /* or adjust as needed */
    }
}

</style>
@endsection
