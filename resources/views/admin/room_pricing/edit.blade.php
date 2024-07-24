@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 offset-md-1">
                <div class="card">
                    <div class="card-header">Edit Room Pricing for {{ $hotel->name }}</div>
                    <div class="card-body">
                        <form action="{{ route('room_pricing.update', ['hotelId' => $hotel->id, 'pricingId' => $pricing->id]) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                            
                            <div class="form-group row">
                                <label for="start_period" class="col-md-2 col-form-label">Start Period</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control @error('start_period') is-invalid @enderror" id="start_period" name="start_period" value="{{ old('start_period', $pricing->start_date) }}" required>
                                    @error('start_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label for="end_period" class="col-md-2 col-form-label">End Period</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control @error('end_period') is-invalid @enderror" id="end_period" name="end_period" value="{{ old('end_period', $pricing->end_date) }}" required>
                                    @error('end_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                            <td><input type="text" class="form-control" name="pricing[{{ $category->id }}][meal]" value="{{ old("pricing.{$category->id}.meal", $pricing->pricing->meal) }}" required></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][sgl]" step="0.01" value="{{ old("pricing.{$category->id}.sgl", $pricing->pricing->sgl) }}"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][dbl]" step="0.01" value="{{ old("pricing.{$category->id}.dbl", $pricing->pricing->dbl) }}"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][tpl]" step="0.01" value="{{ old("pricing.{$category->id}.tpl", $pricing->pricing->tpl) }}"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][quartable]" step="0.01" value="{{ old("pricing.{$category->id}.quartable", $pricing->pricing->quartable) }}"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $category->id }}][family]" step="0.01" value="{{ old("pricing.{$category->id}.family", $pricing->pricing->family) }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                            <div class="mt-4">
                                <h4>Supplement Pricing</h4>
                                <div id="supplements-section">
                                    @if ($supplements->isNotEmpty())
                                        @foreach($supplements as $supplement)
                                            <div class="form-group row mt-3 supplement-row">
                                                <label for="supplement_id_{{ $supplement->id }}" class="col-md-2 col-form-label">{{ $supplement->title }}</label>
                                                <div class="col-md-4">
                                                    <input type="hidden" name="supplements[{{ $supplement->id }}][supplement_id]" value="{{ $supplement->id }}">
                                                    
                                                    @php
                                                        // Default to empty string if no matching supplement is found
                                                        $supplementPrice = '';
                                                        if ($pricing && $pricing->pricing && $pricing->pricing->supplements) {
                                                            $matchingSupplement = $pricing->pricing->supplements->firstWhere('id', $supplement->id);
                                                            if ($matchingSupplement) {
                                                                $supplementPrice = $matchingSupplement->pivot->supplements_price ?? '';
                                                            }
                                                        }
                                                    @endphp
                            
                                                    <input type="number" class="form-control @error("supplements.{$supplement->id}.price") is-invalid @enderror" name="supplements[{{ $supplement->id }}][price]" placeholder="Price" value="{{ old("supplements.{$supplement->id}.price", $supplementPrice) }}">
                                                    @error("supplements.{$supplement->id}.price")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
    <!-- You can add your custom scripts here if needed -->
@endsection
