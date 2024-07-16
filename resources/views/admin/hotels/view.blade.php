@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-4 mb-3">
                    <h2>{{ $hotel->name }}</h2>
                </div>

                <div class="card">
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
            </div>
        </div>
    </div>
@endsection
