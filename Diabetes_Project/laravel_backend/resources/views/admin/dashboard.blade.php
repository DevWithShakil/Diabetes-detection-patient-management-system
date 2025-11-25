@extends('layouts.app')

@section('content')
<div class="container">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Welcome --}}
    <h2 class="mb-2 text-center">Welcome, {{ $user->name }} 👋</h2>
    <h5 class="text-center text-success mb-4">Role: {{ ucfirst($user->role) }}</h5>

    {{-- Top Stats Cards --}}
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>Total Patients</h4>
                <h2 class="text-primary">{{ $totalPatients }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>Total Doctors</h4>
                <h2 class="text-success">{{ $totalDoctors }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>Total Predictions</h4>
                <h2 class="text-danger">{{ $totalPredictions }}</h2>
            </div>
        </div>
    </div>


    {{-- ADMIN QUICK ACTIONS --}}
<div class="card shadow p-4 mb-5">
    <h4 class="mb-4">Admin Quick Actions</h4>

    <div class="admin-tiles">

        <a href="{{ route('doctors.index') }}" class="tile">
            <i class="fas fa-user-md"></i>
            <span>All Doctors</span>
        </a>

        <a href="{{ route('doctors.create') }}" class="tile">
            <i class="fas fa-user-plus"></i>
            <span>Add Doctor</span>
        </a>

        <a href="{{ route('patients.index') }}" class="tile">
            <i class="fas fa-users"></i>
            <span>All Patients</span>
        </a>

        <a href="{{ route('patients.create') }}" class="tile">
            <i class="fas fa-user-plus"></i>
            <span>Add Patient</span>
        </a>

        <a href="{{ route('appointments.index') }}" class="tile">
            <i class="fas fa-calendar-check"></i>
            <span>All Appointments</span>
        </a>

        <a href="{{ route('appointments.create') }}" class="tile">
            <i class="fas fa-calendar-plus"></i>
            <span>Create Appointment</span>
        </a>

        <a href="{{ route('reports.index') }}" class="tile">
            <i class="fas fa-file-medical"></i>
            <span>All Reports</span>
        </a>

        <a href="{{ route('users.index') }}" class="tile">
            <i class="fas fa-user-cog"></i>
            <span>User Management</span>
        </a>

    </div>
</div>



    {{-- Model Accuracy Chart --}}
    <div class="card shadow p-4 mb-5">
        <h4 class="text-center mb-3">Model Accuracy Comparison</h4>

        {{-- Summary --}}
        <div id="accuracySummary" class="text-center mb-3"></div>

        <canvas id="accuracyChart" height="100"></canvas>
    </div>


    {{-- Recent Patients Table --}}
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Recent Patients</h4>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Glucose</th>
                    <th>BMI</th>
                    <th>Final Prediction</th>
                    <th>Report</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @forelse($patients as $index => $patient)
                    @php
                        $result = json_decode($patient->result, true);
                        $final = $result['predictions']['Decision Tree'] ?? ($result['status'] ?? 'Pending');
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->glucose }}</td>
                        <td>{{ $patient->bmi }}</td>

                        <td>
                            @if($final === 'Diabetic')
                                <span class="badge bg-danger">Diabetic</span>
                            @elseif($final === 'Non-Diabetic')
                                <span class="badge bg-success">Non-Diabetic</span>
                            @elseif($final === 'Pending')
                                <span class="badge bg-secondary">Pending</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $final }}</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('patients.report', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                Download PDF
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-muted">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>


{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
const modelLabels = {!! json_encode(array_keys($chartData)) !!};
const modelValues = {!! json_encode(array_values($chartData)) !!};

const barColors = [
    "rgba(54, 162, 235, 0.8)",
    "rgba(255, 159, 64, 0.8)",
    "rgba(75, 192, 192, 0.8)",
    "rgba(153, 102, 255, 0.8)",
    "rgba(255, 99, 132, 0.8)",
];

// Show latest accuracy
document.getElementById("accuracySummary").innerHTML =
    `<strong>Latest Patient Prediction Accuracy</strong>`;

const ctx = document.getElementById('accuracyChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: modelLabels,
        datasets: [{
            data: modelValues,
            backgroundColor: barColors,
            borderColor: barColors.map(c => c.replace("0.8", "1")),
            borderWidth: 1
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, max: 100 }},
        plugins: {
            legend: { display: false },
            datalabels: {
                anchor: 'end',
                align: 'end',
                color: '#000',
                font: { weight: 'bold', size: 14 },
                formatter: val => val + "%"
            },
            tooltip: { enabled: true }
        }
    },
    plugins: [ChartDataLabels]
});
</script>

<style>
.admin-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.tile {
    background: #ffffff;
    border-radius: 14px;
    padding: 25px 10px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all .3s ease;
    text-decoration: none;
    color: #333;
    border: 1px solid #e9e9e9;
}

.tile:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 123, 255, 0.25);
    border-color: #007bff;
}

.tile i {
    font-size: 36px;
    color: #007bff;
    margin-bottom: 10px;
}

.tile span {
    display: block;
    font-size: 15px;
    font-weight: 600;
    margin-top: 5px;
}

</style>

@endsection
