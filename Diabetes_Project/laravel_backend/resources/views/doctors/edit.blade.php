@extends('layouts.app')

@section('title', 'Edit Specialist')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Edit Specialist Profile</h4>
                <p class="small text-muted mb-0">Update doctor information and security settings.</p>
            </div>
            <a href="{{ route('doctors.index') }}" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to List
            </a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 rounded-3 mb-4 d-flex align-items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
            <div>
                <strong class="text-danger">Please correct the following errors:</strong>
                <ul class="mb-0 small text-danger mt-1 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white p-4 border-bottom border-light">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-user-pen fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Update Information</h6>
                        <small class="text-muted">ID: #{{ $doctor->id }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" name="name" value="{{ old('name', $doctor->name) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Specialization <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-stethoscope"></i></span>
                                <select class="form-select bg-light border-start-0 ps-0" name="specialization" required>
                                    <option value="" disabled>Select Specialization</option>
                                    @php
                                        $specs = ['Endocrinologist', 'Diabetologist', 'General Physician', 'Cardiologist', 'Nephrologist', 'Neurologist', 'Nutritionist', 'Ophthalmologist'];
                                    @endphp
                                    @foreach($specs as $spec)
                                        <option value="{{ $spec }}" {{ (old('specialization', $doctor->specialization) == $spec) ? 'selected' : '' }}>
                                            {{ $spec }}
                                        </option>
                                    @endforeach
                                    @if(!in_array($doctor->specialization, $specs))
                                         <option value="{{ $doctor->specialization }}" selected>{{ $doctor->specialization }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control bg-light border-start-0 ps-0" name="email" value="{{ old('email', $doctor->email) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" name="phone" value="{{ old('phone', $doctor->phone) }}">
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="p-3 rounded-3 bg-light border border-light-subtle">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-shield-halved text-primary"></i>
                                        <span class="fw-bold text-dark small text-uppercase ls-1">Security Settings</span>
                                    </div>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">Optional</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" class="form-control bg-white border-start-0 ps-0" name="password" placeholder="Leave blank to keep current">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-check-double"></i></span>
                                            <input type="password" class="form-control bg-white border-start-0 ps-0" name="password_confirmation" placeholder="Repeat new password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4 border-light">

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('doctors.index') }}" class="btn btn-light border px-4 rounded-3 fw-bold">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Update Profile
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<style>
    /* Premium Focus States */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: none;
        border-color: #4361ee;
    }
    .input-group:focus-within .input-group-text {
        border-color: #4361ee;
        color: #4361ee !important;
    }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
