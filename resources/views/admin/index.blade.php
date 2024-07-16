@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold text-xl mb-2">Recent Bookings</h2>
            <p class="text-gray-700">Content goes here...</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold text-xl mb-2">Top Rated Hotels</h2>
            <p class="text-gray-700">Content goes here...</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold text-xl mb-2">Recently Bookings</h2>
            <p class="text-gray-700">Content goes here...</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold text-xl mb-2">Another Card</h2>
            <p class="text-gray-700">Content goes here...</p>
        </div>
    </div>
</div>
@endsection
