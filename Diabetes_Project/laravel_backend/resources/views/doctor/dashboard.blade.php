@extends('layouts.app')

@section('content')
<style>
    /* Custom Timeline CSS for Notes */
    .timeline { border-left: 2px solid #e2e8f0; margin-left: 10px; padding-left: 25px; position: relative; }
    .timeline-item { position: relative; margin-bottom: 15px; }
    .timeline-point {
        width: 12px; height: 12px; background: #fff; border: 3px solid #4361ee;
        border-radius: 50%; position: absolute; left: -32px; top: 5px;
    }
    .note-box { background-color: #f8fafc; border: 1px solid #e2e8f0; transition: 0.2s; }
    .note-box:hover { border-color: #cbd5e1; background-color: #fff; }
</style>

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body p-4 text-white d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-user-doctor fs-4 text-white"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Dr. {{ auth()->user()->name }}</h4>
                    <p class="mb-0 text-white-50 small">Clinical Dashboard & Patient Overview</p>
                </div>
            </div>
            <div class="text-end d-none d-md-block">
                <div class="fw-bold fs-5">{{ date('h:i A') }}</div>
                <div class="small text-white-50">{{ date('l, F d, Y') }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-calendar-check fs-5"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $total }}</h3>
                        <div class="small text-muted fw-bold text-uppercase">Total Appointments</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-hourglass-half fs-5"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $pending }}</h3>
                        <div class="small text-muted fw-bold text-uppercase">Pending Review</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-check-double fs-5"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $approved }}</h3>
                        <div class="small text-muted fw-bold text-uppercase">Confirmed Visits</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-bottom border-light">
            <h6 class="fw-bold mb-0 text-dark text-uppercase small ls-1">Appointment Request Queue</h6>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold" style="width: 25%">Patient</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 15%">Date</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 15%">Status</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 20%">AI Risk Score</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4" style="width: 25%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($appointments as $appointment)

                        @php
                            // Prediction Logic
                            $report = json_decode($appointment->patient->result, true);
                            $prediction = null;
                            if (isset($report['predictions']) && is_array($report['predictions'])) {
                                $votes = collect($report['predictions'])->map(fn($v) => strtolower($v));
                                $diabeticCount = $votes->filter(fn($v) => $v === "diabetic")->count();
                                $nonCount = $votes->filter(fn($v) => $v === "non-diabetic")->count();
                                if ($diabeticCount > $nonCount) $prediction = 1;
                                elseif ($nonCount > $diabeticCount) $prediction = 0;
                            }
                        @endphp

                        <tr class="border-bottom bg-white">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">{{ substr($appointment->patient->name, 0, 1) }}</div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $appointment->patient->name }}</div>
                                        <div class="small text-muted">ID: #{{ str_pad($appointment->patient->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2 small fw-bold text-secondary">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </div>
                            </td>

                            <td class="text-center">
                                @php
                                    $statusClass = match($appointment->status) {
                                        'approved' => 'bg-success text-success',
                                        'pending' => 'bg-warning text-dark',
                                        'cancelled' => 'bg-danger text-danger',
                                        default => 'bg-secondary text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} bg-opacity-10 px-3 py-1 rounded-pill border border-opacity-10 fw-bold">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($prediction === 1)
                                    <div class="d-inline-flex align-items-center gap-1 text-danger fw-bold small bg-danger bg-opacity-10 px-2 py-1 rounded">
                                        <i class="fa-solid fa-triangle-exclamation"></i> High Risk
                                    </div>
                                @elseif($prediction === 0)
                                    <div class="d-inline-flex align-items-center gap-1 text-success fw-bold small bg-success bg-opacity-10 px-2 py-1 rounded">
                                        <i class="fa-solid fa-shield-heart"></i> Low Risk
                                    </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    @if($appointment->status == 'pending')
                                        <form action="{{ route('doctor.appointments.approve', $appointment->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-icon btn-light text-success border-0" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('doctor.appointments.cancel', $appointment->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-icon btn-light text-danger border-0" data-bs-toggle="tooltip" title="Decline">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('doctor.patients.report', $appointment->patient->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-size: 12px;" target="_blank">
                                        View Report
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <tr style="background-color: #fcfcfc;">
                            <td colspan="5" class="p-0 border-bottom">
                                <div class="p-4">
                                    <div class="d-flex gap-3">

                                        <div class="d-flex flex-column align-items-center mt-1" style="width: 30px;">
                                            <i class="fa-solid fa-file-medical text-muted opacity-50 fs-5"></i>
                                            <div class="h-100 border-start border-2 border-light mt-2"></div>
                                        </div>

                                        <div class="w-100">
                                            <h6 class="fw-bold text-dark small text-uppercase mb-3">Clinical Notes & History</h6>

                                            <div class="timeline">
                                                @if ($appointment->notes && count($appointment->notes) > 0)
                                                    @foreach ($appointment->notes as $note)
                                                        <div class="timeline-item">
                                                            <div class="timeline-point"></div>
                                                            <div class="note-box p-3 rounded-3 shadow-sm">
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <strong class="text-primary small">
                                                                        Dr. {{ optional($note->doctor)->name }}
                                                                    </strong>
                                                                    <small class="text-muted" style="font-size: 10px;">
                                                                        {{ $note->created_at->format('M d, h:i A') }}
                                                                    </small>
                                                                </div>
                                                                <p class="mb-0 small text-secondary lh-sm">{{ $note->note }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-muted small fst-italic mb-3 ps-3">No clinical observations recorded yet.</div>
                                                @endif
                                            </div>

                                            <form action="{{ route('doctor.notes.store', $appointment->id) }}" method="POST" class="mt-3">
                                                @csrf
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0 ps-3">
                                                        <i class="fa-regular fa-pen-to-square text-muted"></i>
                                                    </span>
                                                    <input type="text" name="note" class="form-control border-start-0 ps-0 bg-white" placeholder="Add a new observation..." required style="font-size: 14px;">
                                                    <button class="btn btn-primary px-4 fw-bold" type="submit">Save Note</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa-regular fa-calendar-check fa-3x text-muted opacity-25 mb-3"></i>
                                    <h6 class="fw-bold text-dark">No Appointments Found</h6>
                                    <p class="text-muted small">Your schedule is currently clear.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 35px; height: 35px;
        background: linear-gradient(135deg, #4f46e5, #4361ee);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }
    .ls-1 { letter-spacing: 0.5px; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.2s; }
    .btn-icon:hover { background: #f1f5f9; transform: scale(1.05); }

    /* Input Focus */
    .form-control:focus { box-shadow: none; border-color: #4361ee; }
    .input-group:focus-within .input-group-text { border-color: #4361ee; }
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
