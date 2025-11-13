@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">User Management</h2>

    {{-- messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <!-- Add User Form -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Add New User</div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>

                    <div class="col-md-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                    </div>

                    <div class="col-md-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="col-md-2">
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="doctor">Doctor</option>
                            <option value="patient">Patient</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- User Table -->
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Change Role</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>

                <td>
                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex">
                        @csrf
                        @method('PUT')

                        <select name="role" class="form-select me-2 w-auto">
                            <option value="admin"  {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="patient"{{ $user->role == 'patient' ? 'selected' : '' }}>Patient</option>
                        </select>

                        <button class="btn btn-sm btn-primary">Update</button>
                    </form>
                </td>

                <td>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
