@extends('layouts.app')

@section('title', 'Add Specialist')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Register New Doctor</h4>
                <p class="small text-muted mb-0">Create a secure account for the specialist.</p>
            </div>
            <a href="{{ route('doctors.index') }}" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to List
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white p-4 border-bottom border-light">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-user-shield fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Doctor Credentials</h6>
                </div>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('doctors.store') }}">
                    @csrf

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" name="name" placeholder="Dr. John Doe" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Specialization <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-stethoscope"></i></span>
                                <select class="form-select bg-light border-start-0 ps-0" name="specialization" required>
                                    <option value="" selected disabled>Select Specialization</option>
                                    <option value="Endocrinologist">Endocrinologist (Diabetes)</option>
                                    <option value="Diabetologist">Diabetologist</option>
                                    <option value="General Physician">General Physician</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Nephrologist">Nephrologist</option>
                                    <option value="Neurologist">Neurologist</option>
                                    <option value="Nutritionist">Nutritionist</option>
                                    <option value="Ophthalmologist">Ophthalmologist</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control bg-light border-start-0 ps-0" name="email" placeholder="doctor@hospital.com" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" name="phone" placeholder="+880 1XXX XXXXXX">
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border-light my-2">
                            <div class="small text-primary fw-bold text-uppercase" style="letter-spacing: 1px;">Security Setup</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control bg-light border-start-0 ps-0" name="password" placeholder="Min. 8 characters" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-shield-halved"></i></span>
                                <input type="password" class="form-control bg-light border-start-0 ps-0" name="password_confirmation" placeholder="Repeat password" required>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4 border-light">

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('doctors.index') }}" class="btn btn-light border px-4 rounded-3 fw-bold">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-check me-2"></i> Save Doctor
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: none;
        border-color: #4361ee;
    }
    .input-group:focus-within .input-group-text {
        background-color: #fff !important;
        border-color: #4361ee;
        color: #4361ee !important;
    }
    .input-group-text { transition: all 0.3s; }
    .form-control, .form-select { transition: all 0.3s; padding: 12px; }
</style>
@endsection
