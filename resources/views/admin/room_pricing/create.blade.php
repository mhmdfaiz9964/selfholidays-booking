@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 offset-md-1">
                <div class="card">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card-header">Add Room Pricing for {{ $hotel->name }}</div>
                    <div class="card-body">
                        <form action="{{ route('room_pricing.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                            <div class="form-group row">
                                <label for="start_date" class="col-md-2 col-form-label">Start Period</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="Start_date" name="Start_date" required>
                                </div>
                                <label for="end_date" class="col-md-2 col-form-label">End Period</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="End_date" name="End_date" required>
                                </div>
                            </div>

                            <!-- Meals Table -->
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
                                    @foreach($meals as $meal)
                                        <tr>
                                            <td>Standard</td> <!-- Static type, replace with dynamic if needed -->
                                            <td>{{ $meal->title }}</td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $meal->id }}][sgl]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $meal->id }}][dbl]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $meal->id }}][tpl]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $meal->id }}][Quartable]" step="0.01"></td>
                                            <td><input type="number" class="form-control" name="pricing[{{ $meal->id }}][Family]" step="0.01"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <hr>

                            <!-- Supplements Table -->
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>Supplement</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supplements as $supplement)
                                        <tr>
                                            <td>{{ $supplement->title }}</td>
                                            <td>
                                                <input type="number" class="form-control" name="supplements[{{ $supplement->id }}][price]" step="0.01" required>
                                                <input type="hidden" name="supplements[{{ $supplement->id }}][supplement_id]" value="{{ $supplement->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <hr>

                            <div class="form-group">
                                <label for="special_offer">Special Offer</label>
                                <select id="special_offer" name="special_offer" class="form-control">
                                    <option value="disable" {{ old('special_offer', 'disable') == 'disable' ? 'selected' : '' }}>Disable</option>
                                    <option value="enable" {{ old('special_offer') == 'enable' ? 'selected' : '' }}>Enable</option>
                                </select>
                            </div>
                            
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
<script>
    $(document).ready(function() {
        // Add any additional JavaScript or jQuery code here if needed
    });
</script>
@endsection
