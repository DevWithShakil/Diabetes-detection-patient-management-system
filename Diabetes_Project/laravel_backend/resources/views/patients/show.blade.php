@extends('layouts.app')

@section('title', 'Patient Analysis')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Analysis Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}" class="text-decoration-none text-muted">Patients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-light border rounded-pill px-4 fw-bold text-muted">
            <i class="fa-solid fa-arrow-left me-2"></i> Back
        </a>
    </div>

    @php
        $result = json_decode($patient->result, true);
        $predictions = $result['predictions'] ?? [];
        $diabeticCount = 0;
        $totalModels = count($predictions);
        foreach($predictions as $pred) {
            if(strtolower($pred) == 'diabetic') $diabeticCount++;
        }
        $isHighRisk = $totalModels > 0 && ($diabeticCount >= $totalModels / 2);
    @endphp

    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 text-center">
                    <div class="avatar-large mx-auto mb-3">
                        {{ substr($patient->name, 0, 1) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $patient->name }}</h5>
                    <span class="badge bg-light text-muted border rounded-pill px-3">Patient ID: #{{ $patient->id }}</span>
                </div>

                <div class="card-body px-4">
                    <div class="row g-3 mt-1">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center border border-light-subtle">
                                <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 10px;">Age</small>
                                <h5 class="fw-bold text-dark mb-0">{{ $patient->age }} <span class="small text-muted fw-normal">yrs</span></h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center border border-light-subtle">
                                <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 10px;">BMI</small>
                                <h5 class="fw-bold text-dark mb-0">{{ $patient->bmi }}</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-blue-soft rounded-3 d-flex align-items-center justify-content-between border border-primary border-opacity-10">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-droplet text-primary"></i>
                                    <span class="fw-bold text-primary small text-uppercase">Glucose Level</span>
                                </div>
                                <h5 class="fw-bold text-primary mb-0">{{ $patient->glucose ?? 'N/A' }}</h5>
                            </div>
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    <div class="d-grid">
                        <a href="{{ route('patients.report', $patient->id) }}" class="btn btn-primary py-3 rounded-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-file-pdf me-2"></i> Download Full Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between
                    {{ $isHighRisk ? 'bg-danger bg-opacity-10' : 'bg-success bg-opacity-10' }}">

                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0
                            {{ $isHighRisk ? 'bg-danger text-white' : 'bg-success text-white' }}"
                            style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="fa-solid {{ $isHighRisk ? 'fa-triangle-exclamation' : 'fa-shield-heart' }}"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold {{ $isHighRisk ? 'text-danger' : 'text-success' }}">
                                {{ $isHighRisk ? 'High Probability of Diabetes' : 'Low Probability of Diabetes' }}
                            </h6>
                            <p class="small mb-0 opacity-75 text-dark">
                                Based on the consensus of {{ $totalModels }} AI models.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Model Breakdown</h6>
                    <span class="badge bg-light text-dark border"><i class="fa-solid fa-robot me-1"></i> AI Analysis</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Algorithm Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Confidence</th>
                                <th class="py-3 text-end pe-4 text-secondary small text-uppercase fw-bold">Prediction</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($predictions as $model => $pred)
                            @php
                                $isDiabetic = strtolower($pred) == "diabetic";
                            @endphp
                            <tr class="border-bottom-0">
                                <td class="ps-4 fw-bold text-dark">{{ $model }}</td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress" style="height: 6px; width: 80px; background: #e2e8f0;">
                                            <div class="progress-bar {{ $isDiabetic ? 'bg-danger' : 'bg-success' }}"
                                                 role="progressbar" style="width: 90%;"></div>
                                        </div>
                                        <small class="text-muted">High</small>
                                    </div>
                                </td>

                                <td class="text-end pe-4">
                                    @if($isDiabetic)
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i> Diabetic
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            <i class="fa-solid fa-check-circle me-1"></i> Healthy
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No prediction data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded-3 border border-light-subtle d-flex gap-3">
                <i class="fa-solid fa-circle-info text-muted mt-1"></i>
                <p class="small text-muted mb-0 lh-sm">
                    <strong>Medical Disclaimer:</strong> This report is generated by Artificial Intelligence and should not be considered as a final medical diagnosis. Please consult a verified endocrinologist for further validation.
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    .avatar-large {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 32px;
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
    }
    .bg-blue-soft { background-color: #eff6ff; }
</style>
@endsection
