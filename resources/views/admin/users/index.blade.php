@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h2>Users</h2>
                    <a href="{{ route('users.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Create New User
                    </a>                    
                </div>

                {{-- @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')

                                            {{-- Check if user id is not 1 --}}
                                            @if ($user->id !== 1)
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $user->id }})">Delete</button>
                                            @else
                                                <span class="text-muted ml-2">Cannot delete this user</span>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>

                <div class="mt-4">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
@endsection

