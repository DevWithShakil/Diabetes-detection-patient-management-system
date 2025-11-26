@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">My Appointments</h4>
                    <p class="small text-muted mb-0">Track your upcoming and past consultations.</p>
                </div>

                <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                    <i class="fa-solid fa-calendar-plus"></i> <span>Book Appointment</span>
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold" style="width: 10%;">#ID</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 35%;">Doctor Details</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 25%;">Schedule Date</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 15%;">Status</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4" style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small">#{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ substr($appointment->doctor->name ?? 'D', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $appointment->doctor->name ?? 'Unknown Doctor' }}</div>
                                            <div class="small text-muted">Specialist</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2 text-dark">
                                        <div class="bg-light text-secondary rounded p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fa-regular fa-calendar"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold" style="font-size: 14px;">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </span>
                                            <span class="small text-muted" style="font-size: 11px;">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l') }} </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    @php
                                        $statusClass = 'bg-secondary text-secondary';
                                        $icon = 'fa-circle-question';

                                        if($appointment->status == 'approved') {
                                            $statusClass = 'bg-success text-success';
                                            $icon = 'fa-circle-check';
                                        } elseif($appointment->status == 'pending') {
                                            $statusClass = 'bg-warning text-warning';
                                            $icon = 'fa-clock';
                                        } elseif($appointment->status == 'cancelled') {
                                            $statusClass = 'bg-danger text-danger';
                                            $icon = 'fa-circle-xmark';
                                        }
                                    @endphp

                                    <span class="badge {{ $statusClass }} bg-opacity-10 px-3 py-2 rounded-pill d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid {{ $icon }}" style="font-size: 10px;"></i>
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="btn btn-sm btn-light border text-primary fw-bold rounded-pill px-3 shadow-sm btn-view">
                                        View <i class="fa-solid fa-arrow-right ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                            <i class="fa-regular fa-calendar-xmark fa-2x text-muted opacity-50"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">No Appointments Found</h6>
                                        <p class="text-muted small mb-3">You haven't booked any consultations yet.</p>
                                        <a href="{{ route('patient.appointments.create') }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">
                                            Book Now
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom Styling */
    .avatar-circle {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
    }

    .table-hover tbody tr:hover {
        background-color: #f8faff;
        transition: all 0.2s ease;
    }

    .btn-view:hover {
        background-color: #4361ee !important;
        color: white !important;
        border-color: #4361ee !important;
    }
</style>
@endsection
