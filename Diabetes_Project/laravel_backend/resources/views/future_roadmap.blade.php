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
    .phase-1 { background: #e0f2fe; color: #0284c7; }
    .phase-2 { background: #f0fdf4; color: #16a34a; }
    .phase-3 { background: #f3e8ff; color: #9333ea; }

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
        border-bottom: 4px solid transparent;
    }
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08);
        border-color: #fff;
    }

    /* Card Colors */
    .card-blue { border-bottom-color: #4361ee; } .card-blue .icon-box { background: rgba(67, 97, 238, 0.1); color: #4361ee; }
    .card-purple { border-bottom-color: #7209b7; } .card-purple .icon-box { background: rgba(114, 9, 183, 0.1); color: #7209b7; }
    .card-green { border-bottom-color: #2ec4b6; } .card-green .icon-box { background: rgba(46, 196, 182, 0.1); color: #2ec4b6; }
    .card-red { border-bottom-color: #e71d36; } .card-red .icon-box { background: rgba(231, 29, 54, 0.1); color: #e71d36; }
    .card-orange { border-bottom-color: #ff9f1c; } .card-orange .icon-box { background: rgba(255, 159, 28, 0.1); color: #ff9f1c; }
    .card-cyan { border-bottom-color: #4cc9f0; } .card-cyan .icon-box { background: rgba(76, 201, 240, 0.1); color: #4cc9f0; }
    .card-dark { border-bottom-color: #343a40; } .card-dark .icon-box { background: rgba(52, 58, 64, 0.1); color: #343a40; }

    /* Icon Style */
    .icon-box {
        width: 55px; height: 55px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; margin-bottom: 20px;
        transition: 0.3s;
    }

    .card-title { font-weight: 700; font-size: 18px; color: #1e293b; margin-bottom: 10px; }
    .card-text { color: #64748b; font-size: 14px; line-height: 1.6; }

    .step-number {
        position: absolute; top: 20px; right: 20px;
        font-size: 40px; font-weight: 900; color: #f1f5f9;
        z-index: -1; opacity: 0.6;
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

        <div class="col-md-6">
            <div class="feature-card card-blue d-flex flex-column h-100">
                <div class="step-number">01</div>
                <span class="phase-badge phase-1">Data Verification</span>
                <div class="icon-box">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <h4 class="card-title">Verified Lab Results</h4>
                <p class="card-text">
                    Patients may not know their exact Insulin or Glucose levels. We will introduce a <strong>Lab Specialist</strong> role to verify test inputs before AI analysis, ensuring 100% accurate predictions.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="feature-card card-orange d-flex flex-column h-100">
                <div class="step-number">02</div>
                <span class="phase-badge phase-1">Trust Building</span>
                <div class="icon-box">
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

        <div class="col-lg-4 col-md-6">
            <div class="feature-card card-green h-100">
                <div class="step-number">03</div>
                <span class="phase-badge phase-2">AI Logic</span>
                <div class="icon-box">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <h4 class="card-title">Auto Doctor Recommendation</h4>
                <p class="card-text">
                    Our AI will analyze the report and suggest the right doctor (e.g., <strong>Endocrinologist</strong> vs. <strong>Cardiologist</strong>) automatically.
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-card card-red h-100">
                <div class="step-number">04</div>
                <span class="phase-badge phase-2">Geo-Location</span>
                <div class="icon-box">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h4 class="card-title">Nearby Hospital Locator</h4>
                <p class="card-text">
                    Using Google Maps API to detect user location and suggest doctors from the <strong>nearest hospitals</strong> to save travel time.
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="feature-card card-cyan h-100">
                <div class="step-number">05</div>
                <span class="phase-badge phase-2">Generative AI</span>
                <div class="icon-box">
                    <i class="fa-solid fa-carrot"></i>
                </div>
                <h4 class="card-title">AI Diet & Lifestyle Plan</h4>
                <p class="card-text">
                    Generative AI model that creates personalized <strong>Weekly Diet Charts</strong> and <strong>Exercise Routines</strong> based on patient's BMI.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12"><h5 class="text-muted fw-bold border-bottom pb-2">Phase 3: Next-Gen Technology</h5></div>

        <div class="col-md-6">
            <div class="feature-card card-dark h-100 d-flex align-items-start gap-4">
                <div class="icon-box flex-shrink-0 mb-0">
                    <i class="fa-solid fa-wifi"></i>
                </div>
                <div>
                    <div class="step-number" style="right: 10px; top: 10px; font-size: 30px;">06</div>
                    <span class="phase-badge phase-3">IoT Integration</span>
                    <h4 class="card-title mt-2">Smart Wearable Sync</h4>
                    <p class="card-text mb-0">
                        Connecting with <strong>Smart Watches & Glucometers</strong> to fetch real-time heart rate and sugar levels automatically.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="feature-card card-purple h-100 d-flex align-items-start gap-4">
                <div class="icon-box flex-shrink-0 mb-0">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <div class="step-number" style="right: 10px; top: 10px; font-size: 30px;">07</div>
                    <span class="phase-badge phase-3">Remote Care</span>
                    <h4 class="card-title mt-2">Video Consultation</h4>
                    <p class="card-text mb-0">
                        A secure <strong>Video Call</strong> module within the dashboard allowing patients to consult doctors remotely.
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
