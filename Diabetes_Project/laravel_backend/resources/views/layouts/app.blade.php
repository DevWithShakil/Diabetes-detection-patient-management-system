<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Font Awesome for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    @php
        $role = auth()->user()->role ?? 'patient';

        $dashboardRoute = match($role) {
            'admin' => route('admin.dashboard'),
            'doctor' => route('doctor.dashboard'),
            'patient' => route('patient.dashboard'),
            default => '/',
        };

        $panelTitle = match($role) {
            'admin' => 'Diabetes Admin Panel',
            'doctor' => 'Doctor Dashboard',
            'patient' => 'Patient Dashboard',
            default => 'Diabetes System',
        };
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            {{-- Clickable Dynamic Title --}}
            <a class="navbar-brand" href="{{ $dashboardRoute }}">
                <h4 class="m-0">{{ $panelTitle }}</h4>
            </a>

            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    {{ Auth::user()->name ?? 'Guest' }}
                </span>

                <a class="btn btn-outline-light btn-sm"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
