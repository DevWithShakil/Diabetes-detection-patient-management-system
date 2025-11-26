@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">User Management</h4>
            <p class="small text-muted mb-0">Manage system access, roles, and permissions.</p>
        </div>
        <div class="bg-light rounded-pill px-3 py-1 border">
            <i class="fa-solid fa-users text-primary me-2"></i> Total Users: <strong>{{ $users->total() }}</strong>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success border-0 bg-success bg-opacity-10 rounded-3 mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check text-success"></i>
            <div class="text-success fw-bold">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 rounded-3 mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
            <div class="text-danger fw-bold">{{ session('error') }}</div>
        </div>
    @endif

    <!-- 1. Add User Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white p-4 border-bottom border-light">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-user-plus me-2 text-primary"></i> Create New User</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" class="form-control bg-light border-start-0 ps-0" placeholder="John Doe" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0 ps-0" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0 ps-0" placeholder="******" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted">Assign Role</label>
                        <select name="role" class="form-select bg-light" required>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary w-100 fw-bold"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Users Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">User Identity</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Current Role</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Role Management</th>
                        <th class="py-3 text-end pe-4 text-secondary small text-uppercase fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @php
                            $roleColor = match($user->role) {
                                'admin' => 'bg-dark text-white',
                                'doctor' => 'bg-primary bg-opacity-10 text-primary',
                                'patient' => 'bg-success bg-opacity-10 text-success',
                                default => 'bg-secondary bg-opacity-10 text-secondary'
                            };
                        @endphp
                        <tr>
                            <!-- Identity -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td>
                                <span class="badge {{ $roleColor }} px-3 py-2 rounded-pill text-uppercase" style="font-size: 11px;">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <!-- Role Update Form -->
                            <td>
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-select form-select-sm border-0 bg-light fw-bold text-secondary" style="width: 110px; cursor: pointer;">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                        <option value="patient" {{ $user->role == 'patient' ? 'selected' : '' }}>Patient</option>
                                    </select>
                                    <button class="btn btn-sm btn-light border text-primary shadow-sm" title="Update Role">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- Delete Action -->
                            <td class="text-end pe-4">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-light text-danger border-0" title="Delete User">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</div>

<style>
    /* Avatar Style */
    .avatar-circle {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
    }

    /* Input Styles */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: none;
        border: 1px solid #4361ee !important;
    }
    .input-group:focus-within .input-group-text {
        background-color: #fff !important;
        border-color: #4361ee;
        color: #4361ee !important;
    }
    .form-control, .form-select { transition: all 0.3s; padding: 10px 12px; }

    /* Icon Button */
    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: all 0.2s;
    }
    .btn-icon:hover { background-color: #fee2e2; color: #dc2626; }

    /* Table Row */
    .table-hover tbody tr:hover { background-color: #f8faff; transition: all 0.2s; }
</style>
@endsection
