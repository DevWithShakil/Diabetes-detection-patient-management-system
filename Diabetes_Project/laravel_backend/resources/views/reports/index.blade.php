@extends('layouts.app')

@section('title', 'Medical Reports')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Generated Reports</h4>
                    <p class="small text-muted mb-0">Archive of patient diagnosis and AI predictions.</p>
                </div>

                <div class="w-100 w-md-auto">
                    <form method="GET" action="{{ route('reports.index') }}" class="position-relative">
                        <i class="fa-solid fa-search text-muted position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); font-size: 14px;"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="form-control ps-5 rounded-pill border-0 shadow-sm"
                               placeholder="Search patient reports..."
                               style="padding-top: 10px; padding-bottom: 10px; min-width: 300px;">
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold" style="width: 5%;">#ID</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 25%;">Patient Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 10%;">Age</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 20%;">Diagnosis Result</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 20%;">Report Date</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4" style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $patient)
                                @php
                                    $res = json_decode($patient->result, true);
                                    $finalPrediction = $res['predictions']['Decision Tree'] ?? $res['status'] ?? 'N/A';

                                    $badgeClass = 'bg-secondary text-secondary';
                                    $icon = 'fa-circle-question';

                                    if(strtolower($finalPrediction) === 'diabetic') {
                                        $badgeClass = 'bg-danger text-danger';
                                        $icon = 'fa-circle-exclamation';
                                    } elseif(strtolower($finalPrediction) === 'non-diabetic') {
                                        $badgeClass = 'bg-success text-success';
                                        $icon = 'fa-circle-check';
                                    }
                                @endphp

                                <tr>
                                    <td class="ps-4 text-muted fw-bold small">#{{ $patient->id }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3">
                                                {{ substr($patient->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center fw-bold text-muted">{{ $patient->age }}</td>

                                    <td class="text-center">
                                        <span class="badge {{ $badgeClass }} bg-opacity-10 px-3 py-2 rounded-pill d-inline-flex align-items-center gap-2">
                                            <i class="fa-solid {{ $icon }}" style="font-size: 10px;"></i>
                                            {{ ucfirst($finalPrediction) }}
                                        </span>
                                    </td>

                                    <td class="text-muted small">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-regular fa-calendar-check text-muted"></i>
                                            {{ $patient->created_at->format('M d, Y') }}
                                            <span class="text-muted opacity-50">at {{ $patient->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">

                                            <a href="{{ route('patients.download', $patient->id) }}" class="btn btn-sm btn-light border text-primary fw-bold shadow-sm btn-icon" data-bs-toggle="tooltip" title="Download PDF">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>

                                            <form action="{{ route('reports.destroy', $patient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this report permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-light border text-danger fw-bold shadow-sm btn-icon" data-bs-toggle="tooltip" title="Delete Report">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($reports->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $reports->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@if(session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="successToast" class="toast align-items-center border-0 shadow-lg overflow-hidden show" role="alert" aria-live="assertive" aria-atomic="true" style="background: white; border-radius: 12px; min-width: 320px;">
        <div class="d-flex">
            <div style="width: 6px; background: #10b981;"></div>
            <div class="toast-body d-flex align-items-center gap-3 py-3 w-100">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">Success</h6>
                    <small class="text-muted">{{ session('success') }}</small>
                </div>
                <button type="button" class="btn-close ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .avatar-circle {
        width: 35px; height: 35px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
    }

    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: all 0.2s;
    }
    .btn-icon:hover { transform: translateY(-2px); }

    .table-hover tbody tr:hover { background-color: #f8faff; transition: all 0.2s; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Toast
        var toastEl = document.getElementById('successToast');
        if(toastEl){ setTimeout(() => { toastEl.classList.remove('show'); }, 4000); }
    });
</script>
@endsection
