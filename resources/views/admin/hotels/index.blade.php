@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h2>Hotels</h2>
                    <a href="{{ route('hotels.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Create Hotel
                    </a>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>Name</th>
                                        <th>Rating</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotels as $hotel)
                                        <tr>
                                            {{-- <td>{{ $hotel->id }}</td> --}}
                                            <td>{{ $hotel->name }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $hotel->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td>{{ $hotel->location->name ?? 'No Data' }}</td>
                                            <td>
                                                @php
                                                    $categoriesCount = $hotel->roomCategories->count();
                                                    $maxCategories = 1;
                                                @endphp
                                                @foreach ($hotel->roomCategories->take($maxCategories) as $category)
                                                    {{ $category->title }}@if (!$loop->last && $loop->iteration < $maxCategories), @endif
                                                @endforeach
                                                @if ($categoriesCount > $maxCategories)
                                                    ...
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if ($hotel->image)
                                                    <img src="{{ asset('storage/hotel_images/' . $hotel->image) }}" alt="Hotel Image" style="max-width: 100px;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="{{ route('hotels.edit', $hotel->id) }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a class="btn btn-info btn-sm" href="{{ route('hotels.show', $hotel) }}">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this hotel?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {!! $hotels->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
