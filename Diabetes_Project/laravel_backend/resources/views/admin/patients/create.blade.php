@extends('layouts.app')

@section('title', 'Add New Patient')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">New Patient Entry</h4>
                    <p class="small text-muted mb-0">Register a new patient and run initial AI diagnosis.</p>
                </div>
                <a href="{{ route('patients.index') }}" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold text-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom border-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-user-plus fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Patient Registration Form</h6>
                            <small class="text-muted">Please ensure all vital signs are accurate.</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">

                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 rounded-3 mb-4">
                            <strong class="text-danger"><i class="fa-solid fa-circle-exclamation me-2"></i> Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2 small text-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('patients.store') }}" method="POST">
                        @csrf

                        <h6 class="text-uppercase text-primary fw-bold small mb-3 ls-1"><i class="fa-solid fa-id-card me-2"></i> Personal Details</h6>

                        <div class="row g-4 mb-5">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="name" class="form-control bg-light border-start-0 ps-0" placeholder="Enter patient's full name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Age <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-calendar-days"></i></span>
                                    <input type="number" name="age" class="form-control bg-light border-start-0 ps-0" placeholder="e.g. 45" required>
                                </div>
                            </div>
                        </div>

                        <h6 class="text-uppercase text-success fw-bold small mb-3 ls-1"><i class="fa-solid fa-heart-pulse me-2"></i> Clinical Vitals (For AI Analysis)</h6>

                        <div class="p-4 bg-light rounded-4 border border-light-subtle">
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Glucose Level (mg/dL)</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-danger"><i class="fa-solid fa-droplet"></i></span>
                                        <input type="number" name="glucose" class="form-control border-start-0 ps-0" placeholder="e.g. 120" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Blood Pressure (mm Hg)</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-danger"><i class="fa-solid fa-heart-crack"></i></span>
                                        <input type="number" name="blood_pressure" class="form-control border-start-0 ps-0" placeholder="e.g. 80" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">BMI (Body Mass Index)</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-success"><i class="fa-solid fa-weight-scale"></i></span>
                                        <input type="number" step="0.1" name="bmi" class="form-control border-start-0 ps-0" placeholder="e.g. 25.5" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Insulin Level (mu U/ml)</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-info"><i class="fa-solid fa-syringe"></i></span>
                                        <input type="number" name="insulin" class="form-control border-start-0 ps-0" placeholder="e.g. 85" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Skin Thickness (mm)</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-warning"><i class="fa-solid fa-ruler-vertical"></i></span>
                                        <input type="number" name="skin_thickness" class="form-control border-start-0 ps-0" placeholder="e.g. 20" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Diabetes Pedigree Function</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-primary"><i class="fa-solid fa-dna"></i></span>
                                        <input type="number" step="0.001" name="diabetes_pedigree" class="form-control border-start-0 ps-0" placeholder="e.g. 0.587" required>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <button type="reset" class="btn btn-light text-muted fw-bold">Reset Form</button>

                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">
                                <i class="fa-solid fa-microchip me-2"></i> Save & Analyze
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #4361ee;
        box-shadow: none;
    }
    .input-group:focus-within .input-group-text {
        border-color: #4361ee;
    }
    .input-group-text { transition: all 0.3s; }
    .form-control { padding: 12px; transition: all 0.3s; }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
