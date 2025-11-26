@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #334155 100%);">
        <div class="card-body p-4 d-flex align-items-center justify-content-between text-white">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 60px; height: 60px;">
                    {{ substr($patient->name, 0, 1) }}
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Hello, {{ $patient->name }}</h4>
                    <p class="mb-0 text-white-50 small">Welcome to your personal health dashboard.</p>
                </div>
            </div>

            @php
                $report = json_decode($patient->result, true);
                $finalPrediction = null;
                if (isset($report['predictions']) && is_array($report['predictions'])) {
                    $votes = collect($report['predictions'])->map(fn($v) => strtolower(trim($v)));
                    $diabeticVotes = $votes->filter(fn($v) => $v === 'diabetic')->count();
                    $nonVotes = $votes->filter(fn($v) => $v === 'non-diabetic')->count();
                    if ($diabeticVotes > $nonVotes) $finalPrediction = 1;
                    elseif ($nonVotes > $diabeticVotes) $finalPrediction = 0;
                }
                $isApproved = $nextAppointment && $nextAppointment->status === 'approved';
            @endphp

            <div class="d-none d-md-block text-end">
                <small class="text-white-50 d-block text-uppercase fw-bold mb-1" style="font-size: 10px;">Diagnosis Status</small>
                @if($isApproved)
                    @if($finalPrediction === 1)
                        <span class="badge bg-danger bg-opacity-25 border border-danger text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-biohazard me-1"></i> Diabetic</span>
                    @elseif($finalPrediction === 0)
                        <span class="badge bg-success bg-opacity-25 border border-success text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-shield-heart me-1"></i> Non-Diabetic</span>
                    @else
                        <span class="badge bg-secondary bg-opacity-25 border border-secondary text-white px-3 py-2 rounded-pill">Indeterminate</span>
                    @endif
                @else
                    <span class="badge bg-warning bg-opacity-25 border border-warning text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-user-doctor me-1"></i> Waiting for Review</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white p-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-regular fa-calendar-check me-2 text-primary"></i> Next Appointment</h6>
                    @if($nextAppointment)
                        @php
                            $statusClass = match($nextAppointment->status) {
                                'approved' => 'bg-success text-success',
                                'pending' => 'bg-warning text-warning',
                                default => 'bg-secondary text-secondary'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} bg-opacity-10 px-3 py-1 rounded-pill border border-opacity-10">{{ ucfirst($nextAppointment->status) }}</span>
                    @endif
                </div>

                <div class="card-body p-4 d-flex flex-column">
                    @if($nextAppointment)
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex flex-column align-items-center justify-content-center p-2" style="width: 60px; height: 60px;">
                                <span class="fw-bold fs-4 lh-1">{{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d') }}</span>
                                <span class="small text-uppercase fw-bold" style="font-size: 10px;">{{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M') }}</span>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Consultation with {{ $nextAppointment->doctor->name }}</h6>
                                <p class="text-muted small mb-0">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $nextAppointment->time ? \Carbon\Carbon::parse($nextAppointment->time)->format('h:i A') : 'Time Pending' }}
                                </p>
                            </div>
                        </div>

                        @php $latestNote = $nextAppointment->notes->sortByDesc('created_at')->first(); @endphp
                        @if($latestNote)
                            <div class="p-3 bg-light rounded-3 border border-light-subtle mt-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-white p-1 rounded-circle border d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;"><i class="fa-solid fa-user-doctor text-primary" style="font-size: 12px;"></i></div>
                                        <strong class="small text-dark fw-bold">Doctor's Note</strong>
                                    </div>
                                    <span class="badge bg-white border text-secondary fw-normal rounded-pill px-2" style="font-size: 10px;">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $latestNote->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="small text-secondary mb-0 ps-1" style="line-height: 1.5;">{{ $latestNote->note }}</p>
                            </div>
                        @else
                            <div class="text-muted small fst-italic mt-2 mb-3"><i class="fa-regular fa-comment-dots me-1"></i> No notes from doctor yet.</div>
                        @endif

                        @if($nextAppointment->status === 'approved')
                            <div class="mt-auto">
                                <a href="{{ route('patient.report.download', $patient->id) }}" class="btn btn-primary w-100 rounded-3 fw-bold shadow-sm">
                                    <i class="fa-solid fa-file-medical me-2"></i> Download Medical Report
                                </a>
                            </div>
                        @endif

                    @else
                        <div class="text-center py-4 my-auto">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="fa-regular fa-calendar-xmark fa-lg text-muted opacity-50"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Upcoming Visits</h6>
                            <p class="text-muted small mb-3">Schedule a checkup to stay on track.</p>
                            <a href="{{ route('patient.appointments.create') }}" class="btn btn-sm btn-primary px-4 rounded-pill fw-bold">Book Now</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-4">Quick Overview</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-3 text-center">
                                <h3 class="fw-bold text-primary mb-0">{{ $appointmentsCount }}</h3>
                                <small class="text-primary fw-bold text-uppercase opacity-75" style="font-size: 10px;">Visits</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-info bg-opacity-10 rounded-3 text-center">
                                <h3 class="fw-bold text-info mb-0">{{ $patient->glucose ?? 'N/A' }}</h3>
                                <small class="text-info fw-bold text-uppercase opacity-75" style="font-size: 10px;">Glucose Input</small>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3 small text-uppercase">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('patient.simpletest') }}" class="btn btn-light border text-start px-3 py-2 d-flex align-items-center gap-3 hover-shadow">
                            <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-solid fa-flask text-primary"></i></div>
                            <div><div class="fw-bold text-dark small">Update Health Data</div><div class="text-muted" style="font-size: 10px;">Input latest vitals for review</div></div>
                        </a>
                        <a href="{{ route('patient.appointments.index') }}" class="btn btn-light border text-start px-3 py-2 d-flex align-items-center gap-3 hover-shadow">
                            <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-regular fa-calendar-check text-success"></i></div>
                            <div><div class="fw-bold text-dark small">View All Appointments</div><div class="text-muted" style="font-size: 10px;">Check history and status</div></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .hover-shadow:hover { background-color: #fff !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-color: #4361ee !important; transition: all 0.2s; }
</style>
@endsection
