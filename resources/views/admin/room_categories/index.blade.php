@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h2>Room Categories</h2>
                <a href="{{ route('room-categories.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Create New Room Category
                </a>
            </div>

            {{-- Success Message --}}
            {{-- Uncomment the following lines if you want to display a success message --}}
            {{-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif --}}

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th width="200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roomCategories as $roomCategory)
                                <tr>
                                    <td>{{ $roomCategory->id }}</td>
                                    <td>{{ $roomCategory->title }}</td>
                                    <td>{{ strlen($roomCategory->description) > 40 ? substr($roomCategory->description, 0, 40) . '...' : $roomCategory->description }}</td>
                                    <td>
                                        @if ($roomCategory->image)
                                        <img src="{{ asset('images/' . $roomCategory->image) }}" alt="{{ $roomCategory->title }}" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                        No Image
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('room-categories.edit', $roomCategory->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('room-categories.destroy', $roomCategory->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this room category?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
