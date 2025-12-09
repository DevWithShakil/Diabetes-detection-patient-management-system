@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Schedule Appointment</h4>
                    <p class="small text-muted mb-0">Manually book a consultation for a patient.</p>
                </div>
                <a href="{{ route('appointments.index') }}" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold text-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-header bg-white p-4 border-bottom border-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-regular fa-calendar-plus fs-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Appointment Details</h6>
                            <span class="small text-muted">Fill in the required information below</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- Validation Alert --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 rounded-3 mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="fa-solid fa-circle-exclamation text-danger"></i>
                                <strong class="text-danger">Please fix the following errors:</strong>
                            </div>
                            <ul class="mb-0 small text-danger ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success border-0 bg-success bg-opacity-10 rounded-3 mb-4 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <div class="text-success fw-bold">{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Select Patient <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-hospital-user"></i></span>
                                    <select name="patient_id" class="form-select bg-light border-start-0 ps-0" required>
                                        <option value="" disabled selected>Choose Patient</option>
                                        @foreach($patients as $p)
                                            <option value="{{ $p->id }}"
                                                {{ (old('patient_id', $selectedPatientId ?? '') == $p->id) ? 'selected' : '' }}>
                                                {{ $p->name }} (ID: #{{ $p->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Assign Doctor <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user-doctor"></i></span>
                                    <select name="doctor_id" class="form-select bg-light border-start-0 ps-0" required>
                                        <option value="" disabled selected>Choose Specialist</option>
                                        @foreach($doctors as $d)
                                            <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                                {{ $d->name }} ({{ $d->specialization }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Appointment Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                                    <input type="date" name="appointment_date" class="form-control bg-light border-start-0 ps-0" value="{{ old('appointment_date') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Time Slot <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-clock"></i></span>
                                    <input type="time" name="time" class="form-control bg-light border-start-0 ps-0" value="{{ old('time') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Administrative Notes <span class="text-muted fw-normal">(Internal use)</span></label>
                                <textarea name="notes" rows="3" class="form-control bg-light border-0" placeholder="Any specific instructions or details...">{{ old('notes') }}</textarea>
                            </div>

                        </div>

                        <hr class="my-4 border-light">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('appointments.index') }}" class="btn btn-light border px-4 rounded-3 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 rounded-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check-circle me-2"></i> Confirm & Book
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus, textarea:focus {
        background-color: #fff !important;
        box-shadow: none;
        border: 1px solid #4361ee !important;
    }
    .input-group:focus-within .input-group-text {
        background-color: #fff !important;
        border-color: #4361ee;
        color: #4361ee !important;
    }
    .input-group-text { transition: all 0.3s; }
    .form-control, .form-select { transition: all 0.3s; padding: 12px; cursor: pointer; }
    textarea { resize: none; }
</style>
@endsection
