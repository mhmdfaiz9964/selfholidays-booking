@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-4 mb-3">
                    <h2>Create Hotel</h2>
                </div>

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
                <form action="{{ route('hotels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating') }}">
                    </div>

                    <div class="form-group">
                        <label for="location_id">Location:</label>
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="room_category_id">Room Type:</label>
                        <select name="room_category_id[]" id="room_category_id" class="form-control" multiple>
                            <option value="">Select Room Type</option>
                            @foreach ($roomCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage(event)">
                    </div>

                    <div class="form-group">
                        <img id="preview-image" src="#" alt="Preview Image" style="max-width: 200px; display: none;">
                    </div>

                    
                    <div class="form-group">
                        <label for="sales_manager_name">Sales Manager Name:</label>
                        <input type="text" name="sales_manager_name" id="sales_manager_name" class="form-control" value="{{ old('sales_manager_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="sales_manager_contact">Sales Manager Contact:</label>
                        <input type="text" name="sales_manager_contact" id="sales_manager_contact" class="form-control" value="{{ old('sales_manager_contact') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label for="group_of_company">Group of Company:</label>
                        <input type="text" name="group_of_company" id="group_of_company" class="form-control" value="{{ old('group_of_company') }}">
                    </div>
                    <div class="form-group">
                        <label for="pdfs">Attach PDFs</label>
                        <input type="file" name="pdf_urls[]" id="pdf_urls" class="form-control" multiple>
                        @if(isset($hotel) && $hotel->pdfs)
                            @foreach(json_decode($hotel->pdfs) as $pdf)
                                <a href="{{ asset('storage/' . $pdf) }}" target="_blank">{{ basename($pdf) }}</a><br>
                            @endforeach
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview-image');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
