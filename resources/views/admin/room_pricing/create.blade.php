@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Add Room Pricing for {{ $hotel->name }}</div>

                    <div class="card-body">
                        <!-- Your form for creating room pricing -->
                        <form action="{{ route('room_pricing.store') }}" method="POST">
                            @csrf
                            <!-- Hotel ID as hidden input -->
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                            <!-- Room Category -->
                            <div class="form-group">
                                <label for="room_category_id">Room Category:</label>
                                <select name="room_category_id" id="room_category_id" class="form-control">
                                    @foreach ($roomCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Room Only Price -->
                            <div class="form-group">
                                <label for="room_only_price">Room Only Price:</label>
                                <input type="text" name="room_only_price" id="room_only_price" class="form-control">
                            </div>

                            <!-- Date Range for Room Only -->
                            <div class="form-group">
                                <label>Date Range for Room Only:</label>
                                <div class="input-daterange input-group" id="room_only_datepicker">
                                    <input type="date" class="form-control" name="room_only_start_date" />
                                    <div class="input-group-addon">to</div>
                                    <input type="date" class="form-control" name="room_only_end_date" />
                                </div>
                            </div>

                            <!-- Bed and Breakfast Price -->
                            <div class="form-group">
                                <label for="bed_and_breakfast_price">Bed and Breakfast Price:</label>
                                <input type="text" name="bed_and_breakfast_price" id="bed_and_breakfast_price" class="form-control">
                            </div>

                            <!-- Date Range for Bed and Breakfast -->
                            <div class="form-group">
                                <label>Date Range for Bed and Breakfast:</label>
                                <div class="input-daterange input-group" id="bed_and_breakfast_datepicker">
                                    <input type="date" class="form-control" name="bed_and_breakfast_start_date" />
                                    <div class="input-group-addon">to</div>
                                    <input type="date" class="form-control" name="bed_and_breakfast_end_date" />
                                </div>
                            </div>

                            <!-- Half Board Price -->
                            <div class="form-group">
                                <label for="half_board_price">Half Board Price:</label>
                                <input type="text" name="half_board_price" id="half_board_price" class="form-control">
                            </div>

                            <!-- Date Range for Half Board -->
                            <div class="form-group">
                                <label>Date Range for Half Board:</label>
                                <div class="input-daterange input-group" id="half_board_datepicker">
                                    <input type="date" class="form-control" name="half_board_start_date" />
                                    <div class="input-group-addon">to</div>
                                    <input type="date" class="form-control" name="half_board_end_date" />
                                </div>
                            </div>

                            <!-- Full Board Price -->
                            <div class="form-group">
                                <label for="full_board_price">Full Board Price:</label>
                                <input type="text" name="full_board_price" id="full_board_price" class="form-control">
                            </div>

                            <!-- Date Range for Full Board -->
                            <div class="form-group">
                                <label>Date Range for Full Board:</label>
                                <div class="input-daterange input-group" id="full_board_datepicker">
                                    <input type="date" class="form-control" name="full_board_start_date" />
                                    <div class="input-group-addon">to</div>
                                    <input type="date" class="form-control" name="full_board_end_date" />
                                </div>
                            </div>

                            <!-- All Inclusive Price -->
                            <div class="form-group">
                                <label for="all_inclusive_price">All Inclusive Price:</label>
                                <input type="text" name="all_inclusive_price" id="all_inclusive_price" class="form-control">
                            </div>

                            <!-- Date Range for All Inclusive -->
                            <div class="form-group">
                                <label>Date Range for All Inclusive:</label>
                                <div class="input-daterange input-group" id="all_inclusive_datepicker">
                                    <input type="date" class="form-control" name="all_inclusive_start_date" />
                                    <div class="input-group-addon">to</div>
                                    <input type="date" class="form-control" name="all_inclusive_end_date" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
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
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endsection
