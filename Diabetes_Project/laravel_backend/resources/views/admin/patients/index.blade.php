@extends('layouts.app')

@section('title', 'All Patients')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Patient Records</h4>
                    <p class="small text-muted mb-0">Manage patient history, vitals and reports.</p>
                </div>

                <a href="{{ route('patients.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> <span class="d-none d-sm-inline">Register New Patient</span>
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 bg-success bg-opacity-10 rounded-3 mb-4 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <div class="text-success fw-bold">{{ session('success') }}</div>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Patient Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center">Age</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center">Vitals (Glu/BP/BMI)</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center">Status</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Date Added</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3">
                                                {{ substr($patient->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                                <div class="small text-muted">ID: #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center text-muted fw-bold">{{ $patient->age ?? '-' }}</td>

                                    <td class="text-center">
                                        <div class="d-inline-flex gap-2">
                                            <span class="badge bg-light text-dark border" title="Glucose">G: {{ $patient->glucose ?? '-' }}</span>
                                            <span class="badge bg-light text-dark border" title="Blood Pressure">BP: {{ $patient->blood_pressure ?? '-' }}</span>
                                            <span class="badge bg-light text-dark border" title="BMI">BMI: {{ $patient->bmi ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @php
                                            $result = json_decode($patient->result, true);
                                            $status = $result['status'] ?? 'Pending';
                                            $statusClass = ($status === 'Success') ? 'bg-success text-success' : 'bg-warning text-warning';
                                            $icon = ($status === 'Success') ? 'fa-check-circle' : 'fa-clock';
                                        @endphp
                                        <span class="badge {{ $statusClass }} bg-opacity-10 px-3 py-1 rounded-pill border border-opacity-10">
                                            <i class="fa-solid {{ $icon }} me-1"></i> {{ $status }}
                                        </span>
                                    </td>

                                    <td class="text-muted small">
                                        {{ $patient->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">

                                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-icon btn-light border text-primary" data-bs-toggle="tooltip" title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-icon btn-light border text-warning" data-bs-toggle="tooltip" title="Edit Record">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this patient record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-icon btn-light border text-danger" data-bs-toggle="tooltip" title="Delete">
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
                                                <i class="fa-solid fa-folder-open fa-2x text-muted opacity-50"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark">No Patients Found</h6>
                                            <p class="text-muted small">Get started by registering a new patient.</p>
                                            <a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary px-4 rounded-pill">Add Patient</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($patients, 'hasPages') && $patients->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $patients->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    /* Avatar Style */
    .avatar-circle {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
    }

    /* Icon Buttons */
    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: all 0.2s;
    }
    .btn-icon:hover { transform: translateY(-2px); }

    /* Table Hover */
    .table-hover tbody tr:hover { background-color: #f8faff; transition: all 0.2s; }
</style>

<script>
    // Tooltips Init
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection
