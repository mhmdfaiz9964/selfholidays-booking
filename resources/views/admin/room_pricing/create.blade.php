@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 offset-md-1">
                <div class="card">
                    <div class="card-header">Add Room Pricing for {{ $hotel->name }}</div>
                    <div class="card-body">
                        <form action="{{ route('room_pricing.store', $hotel) }}" method="POST">
                            @csrf
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                            
                            <div class="form-group row">
                                <label for="start_period" class="col-md-2 col-form-label">Start Period</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="start_period" name="start_period" required>
                                </div>
                                <label for="end_period" class="col-md-2 col-form-label">End Period</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="end_period" name="end_period" required>
                                </div>
                            </div>
                        
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Meal</th>
                                        <th>SGL</th>
                                        <th>DBL</th>
                                        <th>TPL</th>
                                        <th>Quartable</th>
                                        <th>Family</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hotel->roomCategories as $category)
                                        <tr>
                                            <td>{{ $category->title }}</td>
                                            <td><input type="text" class="form-control" name="pricing[{{ $category->id }}][meal]" required></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][sgl]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][dbl]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][tpl]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][quartable]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][family]" step="0.01"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                            <!-- Separate section for supplements pricing -->
                            <div class="mt-4">
                                <h4>Supplement Pricing</h4>
                                <div id="supplements-section">
                                    @if ($supplements->isNotEmpty())
                                        @foreach($supplements as $supplement)
                                            <div class="form-group row mt-3 supplement-row">
                                                <label for="supplement_id_{{ $supplement->id }}" class="col-md-2 col-form-label">{{ $supplement->title }}</label>
                                                <div class="col-md-4">
                                                    <input type="hidden" name="supplements[{{ $supplement->id }}][supplement_id]" value="{{ $supplement->id }}">
                                                    <input type="number" class="form-control" name="supplements[{{ $supplement->id }}][price]" placeholder="Price">
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- You can add additional fields or controls here if needed -->
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        <br>
                            <div class="form-group row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
