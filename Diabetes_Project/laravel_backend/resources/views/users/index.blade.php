@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">User Management</h2>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Change Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td><td>{{ $user->name }}</td><td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex">
                        @csrf @method('PUT')
                        <select name="role" class="form-select me-2 w-auto">
                            <option value="admin" {{ $user->role=='admin' ? 'selected' : '' }}>Admin</option>
                            <option value="doctor" {{ $user->role=='doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="patient" {{ $user->role=='patient' ? 'selected' : '' }}>Patient</option>
                        </select>
                        <button class="btn btn-sm btn-primary">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection
