@extends('layouts.app')

@section('title', 'Future Roadmap')

@section('content')
<style>
    /* --- Hero Section --- */
    .roadmap-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 80px 0;
        border-radius: 0 0 40px 40px;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }
    .roadmap-hero::before {
        content: ''; position: absolute; top: -50%; right: -10%; width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.15) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%; pointer-events: none;
    }

    /* --- Phase Badge --- */
    .phase-badge {
        font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;
        padding: 6px 12px; border-radius: 30px; display: inline-block; margin-bottom: 15px;
    }
    .phase-1 { background: #e0f2fe; color: #0284c7; } /* Light Blue */
    .phase-2 { background: #f0fdf4; color: #16a34a; } /* Green */
    .phase-3 { background: #fefce8; color: #ca8a04; } /* Yellow */
    .phase-4 { background: #f3e8ff; color: #9333ea; } /* Purple */

    /* --- Feature Card Premium --- */
    .feature-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        z-index: 1;
    }
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08);
        border-color: #fff;
    }

    /* Icon Style */
    .icon-box {
        width: 55px; height: 55px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; margin-bottom: 20px;
        transition: 0.3s;
    }

    /* Card Content */
    .card-title { font-weight: 700; font-size: 18px; color: #1e293b; margin-bottom: 10px; }
    .card-text { color: #64748b; font-size: 14px; line-height: 1.6; }

    /* Step Connector (Visual Line) */
    .step-number {
        position: absolute; top: 20px; right: 20px;
        font-size: 40px; font-weight: 900; color: #f1f5f9;
        z-index: -1; opacity: 0.5;
    }
</style>

<div class="roadmap-hero text-center text-white">
    <div class="container">
        <span class="badge border border-white border-opacity-25 bg-white bg-opacity-10 px-3 py-2 rounded-pill mb-3">
            🚀 Project Vision 2025
        </span>
        <h1 class="fw-bold display-5 mb-3">The Future of Diabetes Care</h1>
        <p class="lead text-white-50 w-75 mx-auto" style="font-size: 16px;">
            Our current AI model is just the beginning. Here is our strategic roadmap to transform this platform into a complete, smart healthcare ecosystem.
        </p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4 mb-5">
        <div class="col-12"><h5 class="text-muted fw-bold border-bottom pb-2">Phase 1: Accuracy & Trust</h5></div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card">
                <div class="step-number">01</div>
                <span class="phase-badge phase-1">Data Accuracy</span>
                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <h4 class="card-title">Verified Lab Results</h4>
                <p class="card-text">
                    Patients may not know their exact Insulin or Glucose levels. We will introduce a <strong>Lab Specialist</strong> role to verify test inputs before AI analysis, ensuring 100% accurate predictions.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card">
                <div class="step-number">02</div>
                <span class="phase-badge phase-1">Trust Building</span>
                <div class="icon-box bg-warning bg-opacity-10 text-warning">
                    <i class="fa-solid fa-star"></i>
                </div>
                <h4 class="card-title">Patient Feedback System</h4>
                <p class="card-text">
                    Building trust is key. After appointments, patients can rate doctors and leave reviews. We will use <strong>Sentiment Analysis</strong> to highlight the best-performing doctors.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12"><h5 class="text-muted fw-bold border-bottom pb-2">Phase 2: Smart Assistance</h5></div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card">
                <div class="step-number">03</div>
                <span class="phase-badge phase-2">AI Logic</span>
                <div class="icon-box bg-success bg-opacity-10 text-success">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <h4 class="card-title">Auto Doctor Recommendation</h4>
                <p class="card-text">
                    Patients often don't know which specialist to visit. Our AI will analyze the report and suggest the right doctor (e.g., <strong>Endocrinologist</strong> vs. <strong>Cardiologist</strong>) automatically.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card">
                <div class="step-number">04</div>
                <span class="phase-badge phase-2">Geo-Location</span>
                <div class="icon-box bg-danger bg-opacity-10 text-danger">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h4 class="card-title">Nearby Hospital Locator</h4>
                <p class="card-text">
                    Using Google Maps API, the app will detect the patient's location and suggest doctors from the <strong>nearest hospitals</strong> to save travel time during emergencies.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card">
                <div class="step-number">05</div>
                <span class="phase-badge phase-2">Generative AI</span>
                <div class="icon-box bg-info bg-opacity-10 text-info">
                    <i class="fa-solid fa-carrot"></i>
                </div>
                <h4 class="card-title">AI Diet & Lifestyle Plan</h4>
                <p class="card-text">
                    Beyond medicine, lifestyle matters. The system will generate personalized <strong>Diet Charts & Exercise Routines</strong> based on the patient's BMI and Diabetes risk level.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12"><h5 class="text-muted fw-bold border-bottom pb-2">Phase 3: Next-Gen Technology</h5></div>

        <div class="col-md-6">
            <div class="feature-card d-flex align-items-start gap-4">
                <div class="icon-box bg-dark bg-opacity-10 text-dark flex-shrink-0 mb-0">
                    <i class="fa-solid fa-wifi"></i>
                </div>
                <div>
                    <div class="step-number" style="right: 10px; top: 10px; font-size: 30px;">06</div>
                    <span class="phase-badge phase-4">IoT Integration</span>
                    <h4 class="card-title">Smart Wearable Sync</h4>
                    <p class="card-text mb-0">
                        Connecting with <strong>Smart Watches & Glucometers</strong>. Patients won't need to type data manually; the app will fetch heart rate and sugar levels in real-time.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="feature-card d-flex align-items-start gap-4">
                <div class="icon-box bg-primary bg-opacity-10 text-primary flex-shrink-0 mb-0">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <div class="step-number" style="right: 10px; top: 10px; font-size: 30px;">07</div>
                    <span class="phase-badge phase-4">Remote Care</span>
                    <h4 class="card-title">Video Consultation</h4>
                    <p class="card-text mb-0">
                        Bringing the clinic to the home. A secure <strong>Video Call</strong> feature will allow patients to consult doctors remotely, ensuring care for rural areas.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 bg-light rounded-4 text-center border border-secondary border-opacity-10 border-dashed">
        <h6 class="fw-bold text-dark">🎓 Research Contribution</h6>
        <p class="text-muted small mb-0 w-75 mx-auto">
            This roadmap proves that our project is scalable and designed to solve real-world healthcare challenges, making it a valuable asset for medical research.
        </p>
    </div>

</div>
@endsection
