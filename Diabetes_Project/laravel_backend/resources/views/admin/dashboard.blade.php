@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #4361ee;
        --bg-light: #f3f4f6;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-light);
    }

    .welcome-banner {
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white;
        border-radius: 16px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(67, 97, 238, 0.4);
        margin-bottom: 30px;
    }
    .welcome-decoration {
        position: absolute; right: -20px; top: -50px;
        font-size: 150px; opacity: 0.1; transform: rotate(15deg);
    }

    .stat-card {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        height: 100%; display: flex; align-items: center; justify-content: space-between;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon {
        width: 56px; height: 56px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 24px;
    }
    .stat-blue { background: #eff6ff; color: #4361ee; }
    .stat-green { background: #ecfdf5; color: #10b981; }
    .stat-red { background: #fef2f2; color: #ef4444; }

    .action-card {
        background: white; border-radius: 16px; padding: 25px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: 100%;
    }
    .action-btn {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 15px;
        text-decoration: none; color: #1f2937; transition: all 0.2s; height: 100px;
    }
    .action-btn:hover {
        background: white; border-color: #4361ee; color: #4361ee;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15); transform: translateY(-2px);
    }
    .action-btn i { font-size: 24px; margin-bottom: 8px; color: #6b7280; }
    .action-btn:hover i { color: #4361ee; }
    .action-btn span { font-size: 13px; font-weight: 600; }

    .custom-table-card {
        background: white; border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden;
    }
    .table thead th {
        background-color: #f9fafb; color: #6b7280; font-weight: 600; text-transform: uppercase;
        font-size: 0.75rem; letter-spacing: 0.05em; padding: 16px;
    }
    .badge-soft-success { background: #d1fae5; color: #065f46; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 11px; }
    .badge-soft-danger { background: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 11px; }
    .badge-soft-pending { background: #fff7ed; color: #9a3412; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 11px; }
</style>

<div class="container py-4">

    <div class="welcome-banner">
        <div class="position-relative z-1">
            <h2 class="fw-bold">Welcome back, {{ Auth::user()->name }}!</h2>
            <p class="mb-0 text-white-50">Admin Dashboard &bull; System Overview</p>
        </div>
        <i class="fa-solid fa-notes-medical welcome-decoration"></i>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Patients</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalPatients }}</h2>
                </div>
                <div class="stat-icon stat-blue"><i class="fa-solid fa-users"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Doctors Onboard</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalDoctors }}</h2>
                </div>
                <div class="stat-icon stat-green"><i class="fa-solid fa-user-doctor"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Predictions</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalPredictions }}</h2>
                </div>
                <div class="stat-icon stat-red"><i class="fa-solid fa-chart-line"></i></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="action-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Latest Patient Analysis</h5>
                        @if(isset($patients) && count($patients) > 0)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                <i class="fa-solid fa-user-clock me-1"></i> Data for: <strong>{{ $patients[0]->name }}</strong>
                            </span>
                        @else
                            <small class="text-muted">No recent data available</small>
                        @endif
                    </div>
                    <span class="badge bg-light text-dark border">Real-time AI Accuracy</span>
                </div>
                <div class="small text-muted mb-3 border-bottom pb-2">
                    Comparing model performance for the most recent prediction request.
                </div>
                <div style="flex-grow:1; position: relative; min-height: 250px;">
                    <canvas id="accuracyChart"></canvas>
                </div>
            </div>
        </div>


        <div class="col-lg-5">
            <div class="action-card">
                <h5 class="fw-bold mb-4">Quick Management</h5>
                <div class="row g-3">
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('doctors.create') }}" class="action-btn">
                            <i class="fa-solid fa-user-plus"></i> <span>Add Doctor</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('doctors.index') }}" class="action-btn">
                            <i class="fa-solid fa-user-md"></i> <span>List Doctors</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('patients.create') }}" class="action-btn">
                            <i class="fa-solid fa-hospital-user"></i> <span>Add Patient</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('patients.index') }}" class="action-btn">
                            <i class="fa-solid fa-users"></i> <span>List Patients</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('appointments.index') }}" class="action-btn">
                            <i class="fa-regular fa-calendar-check"></i> <span>Bookings</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('reports.index') }}" class="action-btn">
                            <i class="fa-solid fa-file-pdf"></i> <span>Reports</span>
                        </a>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill w-100">
                        <i class="fa-solid fa-cog me-1"></i> User Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-table-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Recent Patient Activity</h5>
            <a href="{{ route('patients.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">View All</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Patient Name</th>
                        <th class="text-center">Age</th>
                        <th class="text-center">Vitals (Glu/BMI)</th>
                        <th class="text-center">AI Diagnosis</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        @php

                            $result = json_decode($patient->result, true);
                            $finalStatus = 'Pending';
                            $badgeClass = 'badge-soft-pending';


                            if (isset($result['predictions']) && is_array($result['predictions'])) {
                                $votes = collect($result['predictions'])->map(fn($v) => strtolower(trim($v)));
                                $diabeticCount = $votes->filter(fn($v) => $v === 'diabetic')->count();
                                $nonCount = $votes->filter(fn($v) => $v === 'non-diabetic')->count();

                                if ($diabeticCount > $nonCount) {
                                    $finalStatus = 'Diabetic';
                                    $badgeClass = 'badge-soft-danger';
                                } elseif ($nonCount > $diabeticCount) {
                                    $finalStatus = 'Non-Diabetic';
                                    $badgeClass = 'badge-soft-success';
                                } else {
                                    $finalStatus = 'Indeterminate';
                                }
                            }
                        @endphp
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                        {{ substr($patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                        <div class="small text-muted">ID: #{{ $patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center fw-medium">{{ $patient->age }}</td>
                            <td class="text-center text-muted small">
                                <div>G: <strong>{{ $patient->glucose }}</strong></div>
                                <div>BMI: <strong>{{ $patient->bmi }}</strong></div>
                            </td>
                            <td class="text-center">
                                <span class="{{ $badgeClass }}">{{ $finalStatus }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('patients.report', $patient->id) }}" class="btn btn-sm btn-light text-primary border rounded-pill">
                                    <i class="fa-solid fa-file-arrow-down me-1"></i> Report
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-3"></i><br>
                                No recent patient data available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    // Chart Data passed from Controller
    const modelLabels = {!! json_encode(array_keys($chartData)) !!};
    const modelValues = {!! json_encode(array_values($chartData)) !!};

    const ctx = document.getElementById('accuracyChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(67, 97, 238, 0.7)');
    gradient.addColorStop(1, 'rgba(67, 97, 238, 0.1)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: modelLabels,
            datasets: [{
                label: 'Accuracy %',
                data: modelValues,
                backgroundColor: gradient,
                borderColor: '#4361ee',
                borderWidth: 1,
                borderRadius: 5,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 30
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { borderDash: [5, 5] }
                },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    offset: 5,
                    color: '#1f2937',
                    font: { weight: 'bold' },
                    formatter: Math.round
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
@endsection
