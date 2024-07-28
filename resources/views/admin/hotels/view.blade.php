@extends('admin.layouts.app')

@section('content')
        <div class="row">
            <div class="col-lg-10">
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
                                    <p class="card-text p-1"><strong><i class="fas fa-phone"></i> Hotel Contact:</strong> {{ $hotel->phone }}</p>
                                    <p class="card-text p-1"><strong><i class="fas fa-envelope"></i>Hotel Email :</strong> {{ $hotel->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <p class="card-text p-1"><strong><i class="fas fa-hotel"></i> <span style="color: red;">Group of Company:</span></strong> {{ $hotel->group_of_company }}</p>
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
                        @if(!empty($hotel->pdf_urls) && is_array($hotel->pdf_urls))
                            @foreach($hotel->pdf_urls as $pdfUrl)
                                    <button class="btn btn-outline-danger" onclick="openModal('{{ asset('storage/' . $pdfUrl) }}')">View PDF {{ basename($pdfUrl) }}</button>
                            @endforeach
                    @else
                        <p>No PDFs available.</p>
                    @endif
                
                    <!-- The Modal -->
                    <div id="pdfModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <iframe id="pdfViewer" src="" frameborder="0"></iframe>
                        </div>
                    </div>
                
                    <script>
                        // Function to open the modal
                        function openModal(pdfUrl) {
                            var modal = document.getElementById('pdfModal');
                            var iframe = document.getElementById('pdfViewer');
                            iframe.src = pdfUrl;
                            modal.style.display = 'block';
                        }
                
                        // Function to close the modal
                        function closeModal() {
                            var modal = document.getElementById('pdfModal');
                            modal.style.display = 'none';
                        }
                
                        // Close the modal if the user clicks anywhere outside of the modal
                        window.onclick = function(event) {
                            var modal = document.getElementById('pdfModal');
                            if (event.target == modal) {
                                modal.style.display = 'none';
                            }
                        }
                    </script>
                        <!-- Pricing Table -->
                        <div class="mt-4">
                            <h5 class="card-title">Pricing Information</h5>
                            <a href="{{ route('room_pricing.create', $hotel->id) }}" class="btn btn-success mb-3">Create Pricing</a>
                            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSupplementModal">Add Supplement</a>
                            <a href="#" class="btn btn-info mb-3" data-toggle="modal" data-target="#addMealModal">Create Meal</a>

                            <br>
                            <div class="row">
                                {{-- <!-- Supplements Table -->
                                <div class="col-md-6">
                                    <h5 class="card-title mt-4">Supplements</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="supplementTableBody">
                                            <!-- Supplements will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                        
                                <!-- Meals Table -->
                                <div class="col-md-6">
                                    <h5 class="card-title mt-4">Meals</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="mealTableBody">
                                            <!-- Meals will be loaded here -->
                                        </tbody>
                                    </table> --}}
                                </div>
                            </div>
                            <hr>
                            @if ($mealPricings->count())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Meal Name</th>
                                        <th>SGL</th>
                                        <th>DBL</th>
                                        <th>TPL</th>
                                        <th>Quartable</th>
                                        <th>Family</th>
                                        <th>Start Period</th>
                                        <th>End Period</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mealPricings as $pricing)
                                        @php
                                            $meal = $meals->firstWhere('id', $pricing->meals_id);
                                        @endphp
                                        @if ($meal)
                                            <tr>
                                                <td>{{ $meal->title }}</td>
                                                <td>USD {{ $pricing->sgl }}</td>
                                                <td>USD {{ $pricing->dbl }}</td>
                                                <td>USD {{ $pricing->tpl }}</td>
                                                <td>USD {{ $pricing->Quartable }}</td>
                                                <td>USD {{ $pricing->Family }}</td>
                                                <td>{{ $pricing->Start_date }}</td>
                                                <td>{{ $pricing->End_date }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No meal pricing information available.</p>
                        @endif
                        <hr>
                        @if ($mealPricings->count())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Supplements</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mealPricings as $pricing)
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
                                                    <td>
                                                        <div class="mb-2">
                                                            <input type="text" value="{{ $supplement->title }}: USD - {{ $price }}" disabled class="form-control">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- <tr>
                                            <td>No supplements</td>
                                        </tr> --}}
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No meal pricing information available.</p>
                    @endif
                    
                        <a href="{{ route('hotels.index') }}" class="btn btn-primary mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>

    <!-- Add Supplement Modal -->
    <div class="modal fade" id="addSupplementModal" tabindex="-1" role="dialog" aria-labelledby="addSupplementModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplementModalLabel">Add Supplement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="supplementForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="supplement_title">Title</label>
                            <input type="text" class="form-control" id="supplement_title" name="title" required>
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}"> <!-- Assuming you are passing the hotel ID -->

                        </div>
                        <div id="supplementMessage" class="alert alert-success" style="display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Supplement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Meal Modal -->
    <div class="modal fade" id="addMealModal" tabindex="-1" role="dialog" aria-labelledby="addMealModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMealModalLabel">Create Meal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="mealForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="meal_title">Title</label>
                            <input type="text" class="form-control" id="meal_title" name="title" required>
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}"> <!-- Assuming you are passing the hotel ID -->

                        </div>
                        <div id="mealMessage" class="alert alert-success" style="display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Meal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Delete Supplement
    function deleteSupplement(id) {
        $.ajax({
            url: '{{ route('supplements.destroy', '') }}/' + id,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success response
                alert('Supplement deleted successfully.');
                location.reload(); // Reload the page or update the UI
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    }

    // Delete Meal
    function deleteMeal(id) {
        $.ajax({
            url: '{{ route('meals.destroy', '') }}/' + id,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success response
                alert('Meal deleted successfully.');
                location.reload(); // Reload the page or update the UI
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        // Fetch and display supplements
        function fetchSupplements() {
            $.ajax({
                url: '{{ route('supplements.fetch') }}',
                method: 'GET',
                success: function(response) {
                    let tableBody = $('#supplementTableBody');
                    tableBody.empty();
                    response.forEach(function(supplement) {
                        tableBody.append(`
                            <tr>
                                <td>${supplement.title}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSupplement(${supplement.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }

        // Fetch and display meals
        function fetchMeals() {
            $.ajax({
                url: '{{ route('meals.fetch') }}',
                method: 'GET',
                success: function(response) {
                    let tableBody = $('#mealTableBody');
                    tableBody.empty();
                    response.forEach(function(meal) {
                        tableBody.append(`
                            <tr>
                                <td>${meal.title}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="deleteMeal(${meal.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }

        // Fetch data on page load
        fetchSupplements();
        fetchMeals();

        // Handle Supplement Form Submission
        $('#supplementForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('supplements.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#supplementMessage').text(response.success).show();
                    $('#addSupplementModal').modal('hide');
                    $('#supplementForm')[0].reset();
                    fetchSupplements(); // Refresh supplements list
                },
                error: function(xhr) {
                    $('#supplementMessage').text('An error occurred').show();
                }
            });
        });

        // Handle Meal Form Submission
        $('#mealForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('meals.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#mealMessage').text(response.success).show();
                    $('#addMealModal').modal('hide');
                    $('#mealForm')[0].reset();
                    fetchMeals(); // Refresh meals list
                },
                error: function(xhr) {
                    $('#mealMessage').text('An error occurred').show();
                }
            });
        });
    });
</script>

{{-- <style>
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
          /* Style for the modal background */
          .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Style for the modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            height: 80vh; /* Full-height */
            position: relative;
        }

        /* Style for the iframe */
        .modal-content iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
</style> --}}
