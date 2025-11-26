@extends('layouts.app')

@section('title', 'AI Health Screening')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">AI Health Analysis</h2>
                <p class="text-muted">Enter your vital signs below for an AI-powered diabetes risk assessment.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 bg-success bg-opacity-10 d-flex align-items-center gap-3 rounded-3 mb-4">
                    <i class="fa-solid fa-circle-check text-success fs-5"></i>
                    <div class="text-success fw-bold">{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 rounded-3 mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-circle-exclamation text-danger"></i>
                        <strong class="text-danger">Please correct the following errors:</strong>
                    </div>
                    <ul class="mb-0 small text-danger ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-4 text-center border-0" style="background: linear-gradient(135deg, #4361ee, #3f37c9);">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-heart-pulse fs-2"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Input Vital Signs</h5>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('patient.detection.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">Patient Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user-lock"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 text-dark fw-bold" value="{{ auth()->user()->name }}" disabled>
                                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Age <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="fa-solid fa-calendar-days"></i></span>
                                    <input type="number" name="age" class="form-control border-start-0 ps-0" placeholder="e.g. 30" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Glucose Level <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-danger"><i class="fa-solid fa-droplet"></i></span>
                                    <input type="number" name="glucose" class="form-control border-start-0 ps-0" placeholder="mg/dL (e.g. 120)" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Blood Pressure <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-danger"><i class="fa-solid fa-heart-crack"></i></span>
                                    <input type="number" name="blood_pressure" class="form-control border-start-0 ps-0" placeholder="mm Hg (e.g. 80)" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Skin Thickness <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-warning"><i class="fa-solid fa-ruler-vertical"></i></span>
                                    <input type="number" name="skin_thickness" class="form-control border-start-0 ps-0" placeholder="mm (e.g. 20)" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Insulin Level <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-info"><i class="fa-solid fa-syringe"></i></span>
                                    <input type="number" name="insulin" class="form-control border-start-0 ps-0" placeholder="mu U/ml (e.g. 85)" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">BMI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-success"><i class="fa-solid fa-weight-scale"></i></span>
                                    <input type="number" step="0.1" name="bmi" class="form-control border-start-0 ps-0" placeholder="e.g. 25.5" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">Diabetes Pedigree Function <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="fa-solid fa-dna"></i></span>
                                    <input type="number" step="0.001" name="diabetes_pedigree" class="form-control border-start-0 ps-0" placeholder="e.g. 0.587" required>
                                </div>
                                <div class="form-text text-muted small mt-1"><i class="fa-solid fa-circle-info me-1"></i> A function which scores likelihood of diabetes based on family history.</div>
                            </div>

                        </div>

                        <hr class="my-4 border-light">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow fw-bold text-uppercase ls-1">
                                <i class="fa-solid fa-microchip me-2"></i> Analyze Data
                            </button>
                        </div>

                        <p class="text-center mt-3 mb-0 text-muted small">
                            <i class="fa-solid fa-shield-halved me-1"></i> Your data is securely processed by our AI Model.
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom Input Styling */
    .form-control:focus {
        border-color: #4361ee;
        box-shadow: none;
    }
    .input-group:focus-within .input-group-text {
        border-color: #4361ee;
    }
    .input-group-text {
        transition: all 0.3s;
    }
    .form-control {
        padding: 12px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
