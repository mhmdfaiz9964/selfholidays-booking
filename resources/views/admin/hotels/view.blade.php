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

                        <!-- Pricing Table -->
                        <div class="mt-4">
                            <h5 class="card-title">Pricing Information</h5>
                            <a href="{{ route('room_pricing.create', $hotel->id) }}" class="btn btn-success mb-3">Create Pricing</a>
                            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSupplementModal">Add Supplement</a>
                        <!-- Supplements Table -->
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Supplement</th>
                                        <th>Price</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel->supplements as $supplement)
                                        @foreach ($supplement->pricings as $pricing)
                                            <tr>
                                                <td>{{ $supplement->title }}</td>
                                                <td>{{ $pricing->pivot->supplements_price }}</td>
                                                <td>{{ $pricing->pivot->supplements_start_date }}</td>
                                                <td>{{ $pricing->pivot->supplements_end_date }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Room Type</th>
                                        <th>Meal</th>
                                        <th>SGL</th>
                                        <th>DBL</th>
                                        <th>TPL</th>
                                        <th>Quartable</th>
                                        <th>Family</th>
                                        <th>Start Period</th>
                                        <th>End Period</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel->hotelHasPricing as $pricing)
                                        <tr>
                                            <td>{{ $pricing->pricing->roomCategory->title }}</td>
                                            <td>{{ $pricing->pricing->meal }}</td>
                                            <td>{{ $pricing->pricing->sgl }}</td>
                                            <td>{{ $pricing->pricing->dbl }}</td>
                                            <td>{{ $pricing->pricing->tpl }}</td>
                                            <td>{{ $pricing->pricing->quartable }}</td>
                                            <td>{{ $pricing->pricing->family }}</td>
                                            <td>{{ $pricing->start_date }}</td>
                                            <td>{{ $pricing->end_date }}</td>
                                            <td>
                                                <a href="{{ route('room_pricing.edit', ['hotel' => $hotel->id, 'pricing' => $pricing->id]) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('room_pricing.destroy', $pricing->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            
                                            <script>
                                                function confirmDelete() {
                                                    return confirm('Are you sure you want to delete this pricing?');
                                                }
                                            </script>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('hotels.index') }}" class="btn btn-primary mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal for Adding Supplement -->
<div class="modal" id="addSupplementModal" tabindex="-1" aria-labelledby="addSupplementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplementModalLabel">Add Supplement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to Add Supplement -->
                <form action="{{ route('supplements.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                    <div class="mb-3">
                        <label for="title" class="form-label">Supplement Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
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
