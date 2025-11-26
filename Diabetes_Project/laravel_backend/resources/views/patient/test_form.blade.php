@extends('layouts.app')

@section('title', 'Update Health Data')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Update Health Profile</h4>
                    <p class="small text-muted mb-0">Edit your vital signs for an updated AI analysis.</p>
                </div>
                <a href="{{ route('patient.dashboard') }}" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom border-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-file-pen fs-5"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Current Vitals</h6>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('patient.simpletest.store') }}">
                        @csrf

                        {{-- Alert if updating --}}
                        @if(isset($patient))
                            <div class="alert alert-info small mb-4 border-0 bg-info bg-opacity-10 text-info">
                                <i class="fa-solid fa-circle-info me-1"></i> You are updating existing records. Change values as needed.
                            </div>
                        @endif

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Glucose Level (mg/dL) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-droplet"></i></span>
                                    <input type="number" step="0.1" name="glucose"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('glucose', $patient->glucose ?? '') }}"
                                           placeholder="e.g., 120" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Blood Pressure (mm Hg) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-heart-crack"></i></span>
                                    <input type="number" step="0.1" name="blood_pressure"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('blood_pressure', $patient->blood_pressure ?? '') }}"
                                           placeholder="e.g., 80" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">BMI (Body Mass Index) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-weight-scale"></i></span>
                                    <input type="number" step="0.1" name="bmi"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('bmi', $patient->bmi ?? '') }}"
                                           placeholder="e.g., 25.5" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Age (Years) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-calendar"></i></span>
                                    <input type="number" name="age"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('age', $patient->age ?? '') }}"
                                           placeholder="e.g., 30" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Insulin Level (mu U/ml) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-syringe"></i></span>
                                    <input type="number" step="0.1" name="insulin"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('insulin', $patient->insulin ?? '') }}"
                                           placeholder="e.g., 85" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Skin Thickness (mm) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-ruler-vertical"></i></span>
                                    <input type="number" step="0.1" name="skin_thickness"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('skin_thickness', $patient->skin_thickness ?? '') }}"
                                           placeholder="e.g., 20" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">Diabetes Pedigree Function <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-dna"></i></span>
                                    <input type="number" step="0.001" name="diabetes_pedigree"
                                           class="form-control bg-light border-start-0 ps-0"
                                           value="{{ old('diabetes_pedigree', $patient->diabetes_pedigree ?? '') }}"
                                           placeholder="e.g., 0.5" required>
                                </div>
                                <div class="form-text text-muted small mt-1 ms-1"><i class="fa-solid fa-circle-question me-1"></i> A function which scores likelihood of diabetes based on family history.</div>
                            </div>

                        </div>

                        <hr class="my-4 border-light">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('patient.dashboard') }}" class="btn btn-light border px-4 rounded-3 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 rounded-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-arrows-rotate me-2"></i> Update & Analyze
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Form Styling */
    .form-control:focus { background-color: #fff !important; box-shadow: none; border: 1px solid #4361ee !important; }
    .input-group:focus-within .input-group-text { background-color: #fff !important; border-color: #4361ee; color: #4361ee !important; }
    .input-group-text { transition: all 0.3s; }
    .form-control { transition: all 0.3s; padding: 12px; }
</style>
@endsection
