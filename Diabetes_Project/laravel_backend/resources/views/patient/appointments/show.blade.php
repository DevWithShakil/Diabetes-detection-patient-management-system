@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Consultation Details</h4>
                    <p class="small text-muted mb-0">Appointment ID: #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('patient.appointments.index') }}" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                <div class="card-header border-0 p-4 d-flex align-items-center justify-content-between
                    @if($appointment->status == 'approved') bg-success bg-opacity-10
                    @elseif($appointment->status == 'pending') bg-warning bg-opacity-10
                    @else bg-danger bg-opacity-10 @endif">

                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm
                            @if($appointment->status == 'approved') bg-success text-white
                            @elseif($appointment->status == 'pending') bg-warning text-dark
                            @else bg-danger text-white @endif" style="width: 40px; height: 40px;">
                            <i class="fa-solid
                                @if($appointment->status == 'approved') fa-check
                                @elseif($appointment->status == 'pending') fa-clock
                                @else fa-xmark @endif"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">Appointment Status</h6>
                            <span class="small text-uppercase fw-bold
                                @if($appointment->status == 'approved') text-success
                                @elseif($appointment->status == 'pending') text-warning
                                @else text-danger @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="text-end">
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Scheduled For</small>
                        <h6 class="fw-bold mb-0 text-dark">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                        </h6>
                        @if($appointment->time)
                            <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</small>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">

                    <h6 class="fw-bold text-muted text-uppercase small mb-3 ls-1">Doctor Information</h6>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border border-light-subtle mb-4">
                        <div class="bg-white p-1 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-user-doctor text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">{{ $appointment->doctor->name ?? 'N/A' }}</h5>
                            <p class="text-muted small mb-0">{{ $appointment->doctor->specialization ?? 'General Physician' }}</p>
                        </div>
                        <div class="ms-auto">
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3 disabled">View Profile</a>
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-notes-medical text-primary"></i>
                        <h6 class="fw-bold text-dark mb-0">Doctor's Clinical Notes</h6>
                    </div>

                    @php $notes = $appointment->notes ?? collect(); @endphp

                    @if($notes->isNotEmpty())
                        <div class="timeline ps-2">
                            @foreach($notes as $note)
                                <div class="timeline-item pb-4 ps-4 position-relative border-start border-2 border-light">
                                    <div class="position-absolute top-0 start-0 translate-middle bg-white border border-primary rounded-circle" style="width: 12px; height: 12px; margin-top: 5px;"></div>
                                    <div class="card border-0 bg-light rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong class="small text-primary">Dr. {{ optional($note->doctor)->name }}</strong>
                                            <small class="text-muted" style="font-size: 10px;">{{ $note->created_at->format('M d, h:i A') }}</small>
                                        </div>
                                        <p class="small text-secondary mb-0 lh-sm">{{ $note->note }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 bg-light rounded-3 border border-dashed">
                            <i class="fa-regular fa-comment-dots text-muted mb-2 fs-4"></i>
                            <p class="text-muted small mb-0">No clinical notes recorded yet.</p>
                        </div>
                    @endif

                </div>

                @if($appointment->status === 'approved')
                <div class="card-footer bg-white p-4 border-top">
                    <div class="d-grid">
                        <a href="{{ route('patient.report.download', $appointment->patient_id) }}" class="btn btn-primary rounded-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-file-medical me-2"></i> Download Related Report
                        </a>
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .border-dashed { border-style: dashed !important; }

    /* Timeline fix */
    .timeline-item:last-child { border-left: 0 !important; padding-bottom: 0 !important; }
</style>
@endsection
