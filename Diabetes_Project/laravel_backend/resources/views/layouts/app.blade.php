<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Diabetes Care') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --primary-color: #4361ee;
            --text-light: #94a3b8;
            --bg-body: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            overflow-x: hidden;
        }

        /* --- WRAPPER --- */
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: 100vh;
            overflow: hidden;
        }

        /* --- SIDEBAR CONFIG (DEFAULT CLOSED) --- */
        #sidebar-wrapper {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            transition: margin 0.3s ease-out;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;

            /* DEFAULT: HIDDEN (Negative Margin) */
            margin-left: calc(-1 * var(--sidebar-width));
        }

        /* --- CONTENT AREA CONFIG --- */
        #page-content-wrapper {
            width: 100%;
            transition: margin 0.3s ease-out;
            display: flex;
            flex-direction: column;

            /* DEFAULT: Full Width (No Margin) */
            margin-left: 0;
        }

        /* --- TOGGLED STATE (OPEN) --- */
        /* When 'toggled' class is added via JS, Sidebar Opens */
        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        #wrapper.toggled #page-content-wrapper {
            /* Pushes content when open (Desktop) */
            margin-left: var(--sidebar-width);
        }

        /* --- MOBILE BEHAVIOR --- */
        @media (max-width: 992px) {
            /* Mobile Open State: Overlay Content (Don't push) */
            #wrapper.toggled #page-content-wrapper {
                margin-left: 0;
            }

            /* Optional: Add overlay background on mobile when open */
            #wrapper.toggled #page-content-wrapper::before {
                content: '';
                position: fixed; top:0; left:0; right:0; bottom:0;
                background: rgba(0,0,0,0.5); z-index: 999;
            }
        }

        /* --- SIDEBAR STYLING --- */
        .sidebar-brand {
            padding: 25px 25px; font-size: 1.3rem; font-weight: 800; color: #fff;
            display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.05); text-decoration: none;
        }
        .sidebar-menu {
            padding: 20px 15px; list-style: none; margin: 0; flex-grow: 1; overflow-y: auto;
        }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu a {
            display: flex; align-items: center; padding: 12px 15px;
            color: var(--text-light); text-decoration: none; border-radius: 10px;
            font-weight: 500; font-size: 0.95rem; transition: all 0.2s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--primary-color); color: #fff; box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        .sidebar-menu a i { width: 25px; font-size: 18px; margin-right: 10px; text-align: center; }
        .sidebar-heading {
            font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700;
            padding: 20px 15px 10px; letter-spacing: 0.05em;
        }

        /* --- TOP NAVBAR --- */
        .top-navbar {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px);
            padding: 15px 30px; border-bottom: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 990;
        }
    </style>
</head>
<body>

    @php
        $user = auth()->user();
        $role = $user->role ?? 'patient';
        $dashboardRoute = match($role) {
            'admin' => route('admin.dashboard'),
            'doctor' => route('doctor.dashboard'),
            'patient' => route('patient.dashboard'),
            default => '/',
        };
        $panelTitle = match($role) {
            'admin' => 'Admin Portal',
            'doctor' => 'Doctor Panel',
            'patient' => 'My Health',
            default => 'Diabetes Care',
        };
    @endphp

    <div id="wrapper">

        <div id="sidebar-wrapper">
            <a href="{{ $dashboardRoute }}" class="sidebar-brand">
                <i class="fa-solid fa-heart-pulse text-primary"></i> <span>DiabetesCare</span>
            </a>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ $dashboardRoute }}" class="{{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard
                    </a>
                </li>

                @if($role === 'admin')
                    <li class="sidebar-heading">Administration</li>
                    <li><a href="{{ route('patients.index') }}" class="{{ request()->is('patients*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Patients</a></li>
                    <li><a href="{{ route('doctors.index') }}" class="{{ request()->is('doctors*') ? 'active' : '' }}"><i class="fa-solid fa-user-doctor"></i> Doctors</a></li>
                    <li><a href="{{ route('appointments.index') }}" class="{{ request()->is('appointments*') ? 'active' : '' }}"><i class="fa-regular fa-calendar-check"></i> Appointments</a></li>
                    <li><a href="{{ route('reports.index') }}" class="{{ request()->is('reports*') ? 'active' : '' }}"><i class="fa-solid fa-file-medical"></i> All Reports</a></li>
                @endif

                @if($role === 'doctor')
                    <li class="sidebar-heading">Doctor Tools</li>
                    <li><a href="#"><i class="fa-solid fa-clipboard-user"></i> My Patients</a></li>
                    <li><a href="#"><i class="fa-regular fa-calendar"></i> Schedules</a></li>
                @endif

                @if($role === 'patient')
                    <li class="sidebar-heading">Health Menu</li>
                    <li><a href="{{ route('patient.appointments.index') }}" class="{{ request()->routeIs('patient.appointments.*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-day"></i> My Appointments</a></li>
                    <li><a href="{{ route('patient.appointments.create') }}" class="{{ request()->routeIs('patient.appointments.create') ? 'active' : '' }}"><i class="fa-solid fa-plus-circle"></i> Book New</a></li>
                @endif

                <li style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                        <i class="fa-solid fa-power-off"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div id="page-content-wrapper">

            <nav class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light border shadow-sm" id="menu-toggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h5 class="mb-0 fw-bold text-dark d-none d-md-block">{{ $panelTitle }}</h5>
                </div>

                <div class="dropdown">
                    <button class="btn btn-white border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <div class="text-end d-none d-sm-block line-height-sm">
                            <div class="fw-bold small">{{ Auth::user()->name ?? 'Guest' }}</div>
                            <div class="text-muted" style="font-size: 10px; text-transform: uppercase;">{{ ucfirst($role) }}</div>
                        </div>
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                        <li><h6 class="dropdown-header">Signed in as <br><strong>{{ Auth::user()->email ?? '' }}</strong></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid p-0">
                @yield('content')
            </div>

            <footer class="mt-auto py-4 border-top bg-white">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            &copy; {{ date('Y') }} Diabetes Care AI System. All rights reserved.
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none text-muted me-3">Privacy Policy</a>
                            <a href="#" class="text-decoration-none text-muted me-3">Terms & Conditions</a>

                            <a href="{{ route('future.roadmap') }}" class="text-primary fw-bold text-decoration-none">
                                <i class="fa-solid fa-rocket me-1"></i> Future Roadmap
                            </a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    @if(session('success') || session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="globalToast" class="toast align-items-center border-0 shadow-lg overflow-hidden show" role="alert" style="background: white; border-radius: 12px; min-width: 320px;">
            <div class="d-flex">
                <div style="width: 6px; background: {{ session('error') ? '#ef4444' : '#10b981' }};"></div>
                <div class="toast-body d-flex align-items-center gap-3 py-3 w-100">
                    <div class="{{ session('error') ? 'bg-danger text-danger' : 'bg-success text-success' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                        <i class="fa-solid {{ session('error') ? 'fa-xmark' : 'fa-check' }}"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">{{ session('error') ? 'Error' : 'Success' }}</h6>
                        <small class="text-muted">{{ session('success') ?? session('error') }}</small>
                    </div>
                    <button type="button" class="btn-close ms-auto me-2" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        var wrapper = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            wrapper.classList.toggle("toggled");
        };

        // Auto Hide Toast
        document.addEventListener("DOMContentLoaded", function() {
            var toastEl = document.getElementById('globalToast');
            if(toastEl){ setTimeout(() => { toastEl.classList.remove('show'); }, 4000); }
        });
    </script>
</body>
</html>
