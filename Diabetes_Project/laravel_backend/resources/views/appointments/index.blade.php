@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Appointment Management</h4>
                    <p class="small text-muted mb-0">Manage patient schedules and status updates.</p>
                </div>

                <a href="{{ route('appointments.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                    <i class="fa-solid fa-calendar-plus"></i> <span>New Appointment</span>
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold" style="width: 5%;">#ID</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 20%;">Patient Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 20%;">Doctor Assigned</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 15%;">Date</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 15%;">Current Status</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4" style="width: 25%;">Actions (Update/Delete)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $a)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small">#{{ $a->id }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ substr($a->patient->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $a->patient->name }}</div>
                                            <div class="small text-muted">Patient</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2 text-primary">
                                        <i class="fa-solid fa-user-doctor bg-primary bg-opacity-10 p-2 rounded-circle"></i>
                                        <span class="fw-bold text-dark">{{ $a->doctor->name }}</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2 text-muted fw-bold small">
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ $a->appointment_date }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    @php
                                        $badgeClass = match($a->status) {
                                            'approved' => 'bg-success text-success',
                                            'completed' => 'bg-primary text-primary',
                                            'cancelled' => 'bg-danger text-danger',
                                            default => 'bg-warning text-warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} bg-opacity-10 px-3 py-2 rounded-pill">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end align-items-center gap-2">

                                        <form action="{{ route('appointments.updateStatus', $a) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="form-select form-select-sm border-0 bg-light fw-bold text-secondary shadow-none"
                                                style="width: 110px; cursor: pointer;">
                                                <option value="pending" {{ $a->status=='pending'?'selected':'' }}>Pending</option>
                                                <option value="approved" {{ $a->status=='approved'?'selected':'' }}>Approved</option>
                                                <option value="completed" {{ $a->status=='completed'?'selected':'' }}>Completed</option>
                                                <option value="cancelled" {{ $a->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                            </select>
                                        </form>

                                        <form action="{{ route('appointments.destroy', $a) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-icon btn-light text-danger border-0" onclick="return confirm('Are you sure you want to delete this appointment?')" data-bs-toggle="tooltip" title="Delete">
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

                @if($appointments->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $appointments->links('pagination::bootstrap-5') }}
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
                    <h6 class="mb-0 fw-bold text-dark">Success!</h6>
                    <small class="text-muted">{{ session('success') }}</small>
                </div>
                <button type="button" class="btn-close ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    /* Avatar Styling */
    .avatar-circle {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
    }

    /* Table Hover Effect */
    .table-hover tbody tr:hover {
        background-color: #f8faff;
        transition: all 0.2s ease;
    }

    /* Icon Button */
    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: all 0.2s;
    }
    .btn-icon:hover { background-color: #fee2e2; color: #dc2626; }

    /* Custom Form Select */
    .form-select-sm:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }
</style>

<script>
    // Initialize Tooltips & Toast
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
