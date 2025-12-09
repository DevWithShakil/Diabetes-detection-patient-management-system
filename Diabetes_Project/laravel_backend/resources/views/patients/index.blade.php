@extends('layouts.app')

@section('title', 'Patient Records')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Patient Records</h4>
                    <p class="small text-muted mb-0">View and manage patient history and reports.</p>
                </div>

                <div class="d-flex gap-2 w-100 w-md-auto">
                    <form method="GET" action="{{ route('patients.index') }}" class="position-relative flex-grow-1">
                        <i class="fa-solid fa-search text-muted position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); font-size: 14px;"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="form-control ps-5 rounded-pill border-0 shadow-sm"
                               placeholder="Search patient name..."
                               style="padding-top: 10px; padding-bottom: 10px; min-width: 250px;">
                    </form>

                    <a href="{{ route('patients.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> <span class="d-none d-sm-inline">New Patient</span>
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">#ID</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Patient Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center">Age</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center">Glucose</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Date Added</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                            <tr>
                                <td class="ps-4 text-muted small fw-bold">#{{ $patient->id }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ substr($patient->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                            @php
                                                // Assuming you might save status, or just show ID/Email here
                                                $status = 'Check Report';
                                            @endphp
                                            <div class="small text-muted" style="font-size: 11px;">Record #{{ $patient->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center text-muted fw-bold">{{ $patient->age }}</td>

                                <td class="text-center">
                                    @php
                                        // Dynamic Color Logic
                                        $gluColor = 'bg-secondary';
                                        if($patient->glucose < 100) $gluColor = 'bg-success'; // Good
                                        elseif($patient->glucose >= 100 && $patient->glucose <= 140) $gluColor = 'bg-warning text-dark'; // Pre-diabetes
                                        else $gluColor = 'bg-danger'; // High
                                    @endphp
                                    <span class="badge {{ $gluColor }} bg-opacity-10 text-opacity-75 rounded-pill px-3">
                                        {{ $patient->glucose }} mg/dL
                                    </span>
                                </td>

                                <td class="text-muted small">
                                    <i class="fa-regular fa-calendar me-1"></i> {{ $patient->created_at->format('M d, Y') }}
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-icon btn-light text-primary" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a href="{{ route('patients.download', $patient->id) }}" class="btn btn-icon btn-light text-dark" data-bs-toggle="tooltip" title="Download PDF">
                                            <i class="fa-solid fa-file-arrow-down"></i>
                                        </a>

                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-icon btn-light text-danger" onclick="return confirm('Delete patient record permanently?')" data-bs-toggle="tooltip" title="Delete">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                            <i class="fa-solid fa-clipboard-user fa-2x text-muted opacity-50"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">No Patients Found</h6>
                                        <p class="text-muted small">Start by adding a new patient prediction.</p>
                                        <a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary px-4 rounded-pill">Add Patient</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($patients->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $patients->links('pagination::bootstrap-5') }}
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
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Success!</h6>
                    <small class="text-muted" style="font-size: 0.85rem;">{{ session('success') }}</small>
                </div>
                <button type="button" class="btn-close ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .avatar-circle {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, #10b981, #059669); /* Medical Green Gradient */
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .btn-icon:hover { transform: translateY(-2px); border-color: currentColor; }

    .table-hover tbody tr:hover { background-color: #f8faff; }

    /* Ensure toast shows up */
    .toast.show { display: block; animation: slideIn 0.3s ease-out; }
    @keyframes slideIn { from{ transform: translateX(100%); } to{ transform: translateX(0); } }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        var toastEl = document.getElementById('successToast');
        if(toastEl){ setTimeout(() => { toastEl.classList.remove('show'); }, 4000); }
    });
</script>
@endsection
