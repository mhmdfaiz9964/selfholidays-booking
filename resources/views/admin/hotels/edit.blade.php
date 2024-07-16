@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-4 mb-3">
                    <h2>Edit Hotel</h2>
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

                <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $hotel->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating', $hotel->rating) }}">
                    </div>

                    <div class="form-group">
                        <label for="location_id">Location:</label>
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" {{ $hotel->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="room_category_id">Room Categories:</label>
                        <select name="room_category_id[]" id="room_category_id" class="form-control" multiple>
                            @foreach ($roomCategories as $category)
                                <option value="{{ $category->id }}" {{ $hotel->roomCategories->contains($category->id) ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $hotel->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage(event)">
                    </div>

                    <div class="form-group">
                        @if ($hotel->image)
                            <label>Current Image:</label><br>
                            <img src="{{ asset('storage/hotel_images/' . $hotel->image) }}" alt="Current Image" style="max-width: 200px;">
                            <br><br>
                        @endif
                        <img id="preview-image" src="#" alt="Preview Image" style="max-width: 200px; display: none;">
                    </div>

                    <div class="form-group">
                        <label for="sales_manager_name">Sales Manager Name:</label>
                        <input type="text" name="sales_manager_name" id="sales_manager_name" class="form-control" value="{{ old('sales_manager_name', $hotel->sales_manager_name) }}">
                    </div>

                    <div class="form-group">
                        <label for="sales_manager_contact">Sales Manager Contact:</label>
                        <input type="text" name="sales_manager_contact" id="sales_manager_contact" class="form-control" value="{{ old('sales_manager_contact', $hotel->sales_manager_contact) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
