@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-4 mb-3">
                    <h2>{{ $hotel->name }}</h2>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="card-title mb-4">Hotel Details</h5>
                                <div class="mb-3 gap-3">
                                    <p class="card-text p-1"><strong><i class="fas fa-hotel"></i> Name:</strong> {{ $hotel->name }}</p>
                                    <p class="card-text p-1"><strong><i class="fas fa-star"></i> Rating:</strong>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $hotel->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </p>
                                    <p class="card-text p-1"><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> {{ $hotel->location->name }}</p>
                                    <p class="card-text p-1"><strong><i class="fas fa-info-circle"></i> Description:</strong> {{ $hotel->description }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <p class="card-text p-1"><strong><i class="fas fa-user-tie"></i> Sales Manager:</strong> {{ $hotel->sales_manager_name }}</p>
                                    <p class="card-text p-1"><strong><i class="fas fa-phone"></i> Contact:</strong> {{ $hotel->sales_manager_contact }}</p>
                                </div>

                                <div class="mb-3 p-1">
                                    <strong><i class="fas fa-bed"></i> Room Categories:</strong>
                                    <ul>
                                        @foreach ($hotel->roomCategories as $category)
                                            <li>{{ $category->title }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                @if ($hotel->image)
                                    <img src="{{ asset('storage/hotel_images/' . $hotel->image) }}" alt="{{ $hotel->name }} Image" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('hotels.index') }}" class="btn btn-primary mt-3">Back</a>
                    </div>
                </div>
                <div class="mt-4">
                    <h5>Room Pricings</h5>
                    <div class="mb-3">
                        <a href="{{ route('room_pricing.create', $hotel->id) }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Pricing</a>
                    </div>
                    <div class="row">
                        @foreach ($hotel->roomPricings as $pricing)
                            <div class="col-12 mb-4">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6>{{ $pricing->roomCategory->title }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4 mb-3">
                                                <div class="card border-secondary">
                                                    <div class="card-body">
                                                        <p><strong>R/O Price:</strong> {{ $pricing->room_only_price }}</p>
                                                        <p><strong><i class="fas fa-calendar-alt"></i> Date Range:</strong> {{ $pricing->room_only_start_date }} to {{ $pricing->room_only_end_date }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 mb-3">
                                                <div class="card border-secondary">
                                                    <div class="card-body">
                                                        <p><strong>B/B Price:</strong> {{ $pricing->bed_and_breakfast_price }}</p>
                                                        <p><strong><i class="fas fa-calendar-alt"></i> Date Range:</strong> {{ $pricing->bed_and_breakfast_start_date }} to {{ $pricing->bed_and_breakfast_end_date }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 mb-3">
                                                <div class="card border-secondary">
                                                    <div class="card-body">
                                                        <p><strong>H/B Price:</strong> {{ $pricing->half_board_price }}</p>
                                                        <p><strong><i class="fas fa-calendar-alt"></i> Date Range:</strong> {{ $pricing->half_board_start_date }} to {{ $pricing->half_board_end_date }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 mb-3">
                                                <div class="card border-secondary">
                                                    <div class="card-body">
                                                        <p><strong>F/B Price:</strong> {{ $pricing->full_board_price }}</p>
                                                        <p><strong><i class="fas fa-calendar-alt"></i> Date Range:</strong> {{ $pricing->full_board_start_date }} to {{ $pricing->full_board_end_date }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 mb-3">
                                                <div class="card border-secondary">
                                                    <div class="card-body">
                                                        <p><strong>A/I Price:</strong> {{ $pricing->all_inclusive_price }}</p>
                                                        <p><strong><i class="fas fa-calendar-alt"></i> Date Range:</strong> {{ $pricing->all_inclusive_start_date }} to {{ $pricing->all_inclusive_end_date }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            {{-- Uncomment the following lines if edit and delete routes are defined --}}
                                            {{-- <a href="{{ route('room_pricing.edit', ['hotelId' => $hotel->id, 'roomPricingId' => $pricing->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                            <form action="{{ route('room_pricing.destroy', ['hotelId' => $hotel->id, 'roomPricingId' => $pricing->id]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this pricing?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                            </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
<style>
    .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #007bff;
    color: #fff;
}

.card-body p {
    margin-bottom: 0.5rem;
}

.text-right a,
.text-right button {
    margin-left: 0.5rem;
}

    </style>