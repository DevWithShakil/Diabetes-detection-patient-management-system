@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-soft: #d1fae5;
        --success-text: #065f46;
        --danger-soft: #fee2e2;
        --danger-text: #991b1b;
        --bg-light: #f3f4f6;
        --card-bg: #ffffff;
        --text-dark: #1f2937;
        --text-muted: #6b7280;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-light);
    }

    /* --- Welcome Banner --- */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 16px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(67, 97, 238, 0.4);
        margin-bottom: 30px;
    }
    .welcome-banner h2 { font-weight: 800; margin-bottom: 5px; }
    .welcome-banner p { opacity: 0.9; font-weight: 500; }
    .welcome-decoration {
        position: absolute; right: -20px; top: -50px;
        font-size: 150px; opacity: 0.1; transform: rotate(15deg);
    }

    /* --- Stat Cards --- */
    .stat-card {
        background: var(--card-bg);
        border: none;
        border-radius: 16px;
        padding: 24px;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .stat-icon {
        width: 56px; height: 56px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
    }
    .stat-blue { background: #eff6ff; color: var(--primary-color); }
    .stat-green { background: #ecfdf5; color: #10b981; }
    .stat-red { background: #fef2f2; color: #ef4444; }

    /* --- Action Grid --- */
    .action-card {
        background: white; border-radius: 16px; padding: 25px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    .action-btn {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: #f9fafb; border: 1px solid #e5e7eb;
        border-radius: 12px; padding: 15px;
        text-decoration: none; color: var(--text-dark);
        transition: all 0.2s; height: 100px;
    }
    .action-btn:hover {
        background: white; border-color: var(--primary-color);
        color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
        transform: translateY(-2px);
    }
    .action-btn i { font-size: 24px; margin-bottom: 8px; color: var(--text-muted); transition: 0.2s; }
    .action-btn:hover i { color: var(--primary-color); }
    .action-btn span { font-size: 13px; font-weight: 600; text-align: center; line-height: 1.2; }

    /* --- Table Styles --- */
    .custom-table-card {
        background: white; border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .table thead th {
        background-color: #f9fafb;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
        padding: 16px;
    }
    .table tbody td { padding: 16px; vertical-align: middle; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; }
    .table-hover tbody tr:hover { background-color: #f9fafb; }

    /* Badges */
    .badge-soft-success { background: var(--success-soft); color: var(--success-text); padding: 6px 12px; border-radius: 20px; font-weight: 600; }
    .badge-soft-danger { background: var(--danger-soft); color: var(--danger-text); padding: 6px 12px; border-radius: 20px; font-weight: 600; }
    .badge-soft-pending { background: #fff7ed; color: #9a3412; padding: 6px 12px; border-radius: 20px; font-weight: 600; }
</style>

<div class="container py-4">

    {{-- 1. Welcome Header --}}
    <div class="welcome-banner">
        <div class="position-relative z-1">
            <h2>Welcome back, {{ $user->name }}!</h2>
            <p class="mb-0 text-white-50">Admin Dashboard &bull; {{ ucfirst($user->role) }} Panel</p>
        </div>
        <i class="fa-solid fa-notes-medical welcome-decoration"></i>
    </div>

    {{-- 2. Key Metrics Row --}}
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

    {{-- 3. Split View: Charts & Actions --}}
    <div class="row g-4 mb-4">

        {{-- Left: Accuracy Chart --}}
        <div class="col-lg-7">
            <div class="action-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Model Accuracy</h5>
                    <span class="badge bg-light text-dark border">Real-time Data</span>
                </div>
                <div id="accuracySummary" class="small text-muted mb-3"></div>

                <div style="flex-grow:1; position: relative; min-height: 250px;">
                    <canvas id="accuracyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Right: Quick Actions (Grid) --}}
        <div class="col-lg-5">
            <div class="action-card">
                <h5 class="fw-bold mb-4">Quick Management</h5>
                <div class="row g-3">
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('doctors.create') }}" class="action-btn">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Add Doctor</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('doctors.index') }}" class="action-btn">
                            <i class="fa-solid fa-user-md"></i>
                            <span>List Doctors</span>
                        </a>
                    </div>

                    <div class="col-6 col-sm-4">
                        <a href="{{ route('patients.create') }}" class="action-btn">
                            <i class="fa-solid fa-hospital-user"></i>
                            <span>Add Patient</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('patients.index') }}" class="action-btn">
                            <i class="fa-solid fa-users"></i>
                            <span>List Patients</span>
                        </a>
                    </div>

                    <div class="col-6 col-sm-4">
                        <a href="{{ route('appointments.index') }}" class="action-btn">
                            <i class="fa-regular fa-calendar-check"></i>
                            <span>Bookings</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('reports.index') }}" class="action-btn">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Reports</span>
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

    {{-- 4. Recent Patients Table --}}
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
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $index => $patient)
                        @php
                            $result = json_decode($patient->result, true);
                            $final = $result['predictions']['Decision Tree'] ?? ($result['status'] ?? 'Pending');
                            // Helper for badge color
                            $badgeClass = 'badge-soft-pending';
                            if($final === 'Diabetic') $badgeClass = 'badge-soft-danger';
                            if($final === 'Non-Diabetic') $badgeClass = 'badge-soft-success';
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
                                <span class="{{ $badgeClass }}">{{ $final }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('patients.report', $patient->id) }}" class="btn btn-sm btn-light text-primary border rounded-pill">
                                    <i class="fa-solid fa-download me-1"></i> PDF
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
    const modelLabels = {!! json_encode(array_keys($chartData)) !!};
    const modelValues = {!! json_encode(array_values($chartData)) !!};

    document.getElementById("accuracySummary").innerHTML = "Comparison across AI models";

    const ctx = document.getElementById('accuracyChart').getContext('2d');

    // Premium Gradient
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
            scales: {
                y: { beginAtZero: true, max: 100, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end', align: 'top', color: '#1f2937', font: { weight: 'bold' },
                    formatter: Math.round
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
@endsection
