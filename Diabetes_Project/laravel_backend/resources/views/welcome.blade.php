<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Diabetes Care | AI Powered Health</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <style>
    :root {
      /* Premium Palette */
      --primary-dark: #0f172a;       /* Deep Navy */
      --primary-brand: #3b82f6;      /* Bright Royal Blue */
      --accent-teal: #14b8a6;        /* Medical Teal */
      --bg-surface: #f8fafc;         /* Very Light Grey-Blue */
      --text-main: #334155;
      --text-muted: #64748b;
      --glass-border: rgba(255, 255, 255, 0.6);
      --glass-bg: rgba(255, 255, 255, 0.7);
      --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.08);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-surface);
      color: var(--text-main);
      overflow-x: hidden;
    }

    /* --- Navbar Glass Effect --- */
    .navbar {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      padding: 16px 0;
      transition: all 0.3s ease;
    }
    .brand-logo {
      width: 40px; height: 40px;
      background: linear-gradient(135deg, var(--primary-brand), var(--accent-teal));
      color: white; border-radius: 10px;
      display: grid; place-items: center; font-size: 18px;
    }
    .nav-link { font-weight: 600; color: var(--text-main); margin: 0 10px; }
    .nav-link:hover { color: var(--primary-brand); }

    .btn-premium {
      background: var(--primary-dark);
      color: #fff;
      padding: 10px 24px;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s;
      border: none;
      box-shadow: 0 4px 15px rgba(15, 23, 42, 0.2);
    }
    .btn-premium:hover { background: #1e293b; transform: translateY(-2px); color: #fff; }

    /* --- Hero Section --- */
    .hero-section {
      position: relative;
      padding: 100px 0 60px;
      overflow: hidden;
    }
    /* Abstract Background Blur blobs */
    .bg-blob {
      position: absolute; width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(255,255,255,0) 70%);
      border-radius: 50%; z-index: -1;
      animation: float 10s infinite alternate;
    }
    .blob-1 { top: -100px; right: -100px; }
    .blob-2 { bottom: 0; left: -150px; background: radial-gradient(circle, rgba(20,184,166,0.1) 0%, rgba(255,255,255,0) 70%); }

    @keyframes float { 0% { transform: translate(0,0); } 100% { transform: translate(30px, 50px); } }

    .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1.1;
      letter-spacing: -0.02em;
      color: var(--primary-dark);
      margin-bottom: 20px;
    }
    .hero-subtitle { font-size: 1.15rem; color: var(--text-muted); margin-bottom: 35px; line-height: 1.6; }

    .stat-pill {
      display: inline-flex; align-items: center; gap: 10px;
      background: white; padding: 10px 20px; border-radius: 100px;
      box-shadow: var(--shadow-soft);
      border: 1px solid white;
      margin-right: 15px; margin-bottom: 15px;
    }
    .stat-pill i { color: var(--accent-teal); }
    .stat-pill strong { color: var(--primary-dark); }

    /* --- Bento Grid Features --- */
    .bento-card {
      background: white;
      border-radius: 24px;
      padding: 30px;
      height: 100%;
      border: 1px solid rgba(255,255,255,0.8);
      box-shadow: var(--shadow-soft);
      transition: transform 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .bento-card:hover { transform: translateY(-5px); border-color: var(--primary-brand); }
    .bento-icon {
      width: 50px; height: 50px; border-radius: 14px;
      display: grid; place-items: center; font-size: 20px;
      margin-bottom: 20px;
    }
    .icon-blue { background: #eff6ff; color: var(--primary-brand); }
    .icon-teal { background: #f0fdfa; color: var(--accent-teal); }
    .icon-purple { background: #f5f3ff; color: #8b5cf6; }

    /* --- Process Steps --- */
    .step-card {
      text-align: center; position: relative; z-index: 2;
      background: white; padding: 25px; border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    .step-num {
      width: 35px; height: 35px; background: var(--primary-dark); color: white;
      border-radius: 50%; font-weight: 700; display: grid; place-items: center;
      margin: 0 auto 15px;
    }

    /* --- Testimonials --- */
    .review-card {
      background: white; padding: 30px; border-radius: 20px;
      border-left: 4px solid var(--primary-brand);
      box-shadow: var(--shadow-soft);
    }

    /* --- Footer --- */
    footer { background: var(--primary-dark); color: #94a3b8; padding: 60px 0 30px; }
    footer h5 { color: white; font-weight: 700; margin-bottom: 20px; }
    footer a { color: #cbd5e1; text-decoration: none; transition: 0.2s; }
    footer a:hover { color: var(--primary-brand); }

    /* --- Modal Tweaks to match theme --- */
    .auth-modal .modal-content { border-radius: 24px; border: none; }
    .auth-tabs button {
      border: none; background: transparent; padding: 10px 20px;
      font-weight: 600; color: var(--text-muted); border-radius: 10px;
      transition: 0.3s; width: 50%;
    }
    .auth-tabs button.active {
      background: var(--primary-dark); color: white;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }
    .form-control {
      padding: 12px 15px; border-radius: 12px; border: 1px solid #e2e8f0;
      background: #f8fafc;
    }
    .form-control:focus {
      background: white; border-color: var(--primary-brand); box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
    }

    @media (max-width: 991px) {
      .hero-title { font-size: 2.5rem; }
      .hero-img-col { display: none; } /* Hide visual on mobile to clean up */
    }
  </style>
</head>
<body>

  <div class="bg-blob blob-1"></div>
  <div class="bg-blob blob-2"></div>

  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <div class="brand-logo"><i class="fa-solid fa-heart-pulse"></i></div>
        <div style="line-height:1.1">
          <div style="font-weight:800; font-size:18px; color:var(--primary-dark);">DiabetesCare</div>
          <div style="font-size:11px; font-weight:600; color:var(--accent-teal); letter-spacing:0.5px;">AI MEDTECH</div>
        </div>
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#how-it-works">Process</a></li>
          <li class="nav-item ms-lg-3">
            <button class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#authModal">
              Sign In / Register <i class="fa-solid fa-arrow-right ms-2" style="font-size:12px;"></i>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero-section d-flex align-items-center">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="d-inline-block px-3 py-1 rounded-pill mb-3" style="background:#fff7ed; border:1px solid #ffedd5; color:#c2410c; font-size:13px; font-weight:700;">
    <i class="fa-solid fa-user-doctor me-1"></i> Expert Medical Guidance
</div>

<h1 class="hero-title">
    Smart Screening for <br>
    <span style="background: linear-gradient(to right, var(--primary-brand), var(--accent-teal)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Better Diabetes Care</span>
</h1>

<p class="hero-subtitle">
    We combine advanced technology with expert care to give you accurate risk assessments. From analysis to doctor consultations, get the complete guidance your health deserves.
</p>

          <div class="d-flex flex-wrap gap-3 mb-5">
            <button class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#authModal">Check Your Risk Now</button>
            <a href="#how-it-works" class="btn btn-light" style="border-radius:50px; padding:10px 24px; font-weight:600; color:var(--text-main);">How it works</a>
          </div>

          {{-- <div class="d-flex flex-wrap">
            <div class="stat-pill">
              <i class="fa-solid fa-user-check"></i>
              <span><strong>15k+</strong> Patients</span>
            </div>
            <div class="stat-pill">
              <i class="fa-solid fa-bullseye"></i>
              <span><strong>98%</strong> Accuracy</span>
            </div>
            <div class="stat-pill">
              <i class="fa-solid fa-user-doctor"></i>
              <span><strong>Verified</strong> Doctors</span>
            </div>
          </div> --}}
        </div>

        <div class="col-lg-6 hero-img-col" data-aos="fade-left">
          <div style="position:relative;">
             <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_5njp3vgg.json" background="transparent" speed="1" style="width: 100%; height: auto;" loop autoplay></lottie-player>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="features" class="py-5">
    <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
        <h6 style="color:var(--primary-brand); font-weight:700; text-transform:uppercase; letter-spacing:1px;">Core Features</h6>
        <h2 style="font-weight:800; color:var(--primary-dark);">Complete Metabolic Health</h2>
      </div>

      <div class="row g-4">
        <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
          <div class="bento-card d-flex flex-column justify-content-center">
            <div class="bento-icon icon-blue"><i class="fa-solid fa-brain"></i></div>
            <h4 style="font-weight:700;">AI Risk Engine</h4>
            <p class="text-muted">Our proprietary machine learning algorithm analyzes 8+ vital parameters (Glucose, BMI, Age, etc.) to predict diabetes probability instantly.</p>
            <div class="mt-3">
              <span class="badge bg-primary bg-opacity-10 text-primary">Machine Learning</span>
              <span class="badge bg-primary bg-opacity-10 text-primary">Instant Results</span>
            </div>
          </div>
        </div>

        <div class="col-md-5" data-aos="fade-up" data-aos-delay="200">
          <div class="bento-card">
            <div class="bento-icon icon-teal"><i class="fa-solid fa-file-medical"></i></div>
            <h4 style="font-weight:700;">Smart Reports</h4>
            <p class="text-muted">Generate PDF reports that you can directly share with your doctor via WhatsApp or Email.</p>
          </div>
        </div>

        <div class="col-md-5" data-aos="fade-up" data-aos-delay="300">
          <div class="bento-card">
             <div class="bento-icon icon-purple"><i class="fa-solid fa-stethoscope"></i></div>
             <h4 style="font-weight:700;">Doctor Connect</h4>
             <p class="text-muted">High risk? Book an appointment instantly with verified specialists near you.</p>
          </div>
        </div>

        <div class="col-md-7" data-aos="fade-up" data-aos-delay="400">
          <div class="bento-card" style="background: var(--primary-dark); color:white; border:none;">
            <div class="row align-items-center">
              <div class="col-7">
                <h4 style="font-weight:700; color:white;">Secure Health Vault</h4>
                <p style="opacity:0.8;">Your data is encrypted. Track your glucose history over months and see visual progress charts.</p>
                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold mt-2">Start Tracking</button>
              </div>
              <div class="col-5 text-end">
                <i class="fa-solid fa-shield-halved fa-4x" style="opacity:0.2;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="how-it-works" class="py-5" style="background:white;">
    <div class="container">
      <div class="row justify-content-center text-center mb-5" data-aos="fade-up">
        <div class="col-md-8">
          <h2 style="font-weight:800; color:var(--primary-dark);">From Input to Insight</h2>
          <p class="text-muted">A streamlined clinical workflow designed for patients.</p>
        </div>
      </div>

      <div class="row g-4 position-relative">
        <div class="d-none d-md-block" style="position:absolute; top:45px; left:0; width:100%; height:2px; background: repeating-linear-gradient(to right, #e2e8f0 0, #e2e8f0 10px, transparent 10px, transparent 20px); z-index:0;"></div>

        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
          <div class="step-card">
            <div class="step-num">1</div>
            <h6 class="fw-bold">Input Data</h6>
            <p class="small text-muted mb-0">Enter basic vitals like Glucose, BP, and BMI.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
          <div class="step-card">
            <div class="step-num">2</div>
            <h6 class="fw-bold">AI Analysis</h6>
            <p class="small text-muted mb-0">Model calculates risk score in milliseconds.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
          <div class="step-card">
            <div class="step-num">3</div>
            <h6 class="fw-bold">Report</h6>
            <p class="small text-muted mb-0">Get a detailed PDF with actionable advice.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
          <div class="step-card">
            <div class="step-num">4</div>
            <h6 class="fw-bold">Consult</h6>
            <p class="small text-muted mb-0">Book a doctor if risk is detected.</p>
          </div>
        </div>
      </div>
    </div>
  </section>



  <footer>
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4">
          <div class="d-flex align-items-center gap-2 mb-3 text-white">
            <i class="fa-solid fa-heart-pulse fa-lg text-primary"></i>
            <span class="h5 mb-0">DiabetesCare</span>
          </div>
          <p class="small opacity-75">Empowering patients with AI-driven insights for a healthier tomorrow.</p>
        </div>
        <div class="col-lg-2 col-6">
          <h5>Platform</h5>
          <ul class="list-unstyled d-flex flex-column gap-2 small">
            <li><a href="#">Prediction</a></li>
            <li><a href="#">Doctors</a></li>
            <li><a href="#">Reports</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-6">
          <h5>Company</h5>
          <ul class="list-unstyled d-flex flex-column gap-2 small">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Privacy</a></li>
            <li><a href="#">Terms</a></li>
          </ul>
        </div>
        <div class="col-lg-4">
           <h5>Newsletter</h5>
           <div class="input-group">
             <input type="text" class="form-control border-0" placeholder="Email address">
             <button class="btn btn-primary">Subscribe</button>
           </div>
        </div>
      </div>
      <div class="border-top border-secondary border-opacity-25 mt-5 pt-4 text-center small opacity-50">
        &copy; <span id="year"></span> Diabetes Care System. All rights reserved.
      </div>
    </div>
  </footer>


  <div class="modal fade auth-modal" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-4">
        <div class="modal-body p-0">
          <div class="row g-0">
            <div class="col-md-6 pe-md-4 d-flex flex-column justify-content-center">
              <h4 class="fw-bold mb-1 text-dark">Welcome Back</h4>
              <p class="small text-muted mb-4">Manage your health predictions securely.</p>

              <div class="auth-tabs d-flex gap-2 p-1 bg-light rounded-3 mb-4">
                <button id="authTabLogin" class="active">Login</button>
                <button id="authTabRegister">Register</button>
              </div>

              <div id="authLogin">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Email Address</label>
                    <input name="email" required type="email" class="form-control" placeholder="name@example.com">
                  </div>
                  <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Password</label>
                    <input name="password" required type="password" class="form-control" placeholder="••••••••">
                  </div>
                  <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-premium w-100 rounded-3">Sign In</button>
                  </div>
                </form>
              </div>

              <div id="authRegister" style="display:none;">
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="mb-2">
                    <label class="form-label small fw-bold text-muted">Full Name</label>
                    <input name="name" required type="text" class="form-control" placeholder="John Doe">
                  </div>
                  <div class="mb-2">
                    <label class="form-label small fw-bold text-muted">Email</label>
                    <input name="email" required type="email" class="form-control" placeholder="name@example.com">
                  </div>
                  <div class="row g-2 mb-3">
                    <div class="col-6">
                      <label class="form-label small fw-bold text-muted">Password</label>
                      <input name="password" required minlength="8" type="password" class="form-control" placeholder="Min 8 chars">
                    </div>
                    <div class="col-6">
                      <label class="form-label small fw-bold text-muted">Confirm</label>
                      <input name="password_confirmation" required type="password" class="form-control" placeholder="Repeat">
                    </div>
                  </div>
                  <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-premium w-100 rounded-3">Create Account</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-light rounded-4 position-relative overflow-hidden">
               <div style="position:absolute; top:-50px; right:-50px; width:150px; height:150px; background:rgba(59,130,246,0.1); border-radius:50%;"></div>
               <div style="position:absolute; bottom:-50px; left:-50px; width:150px; height:150px; background:rgba(20,184,166,0.1); border-radius:50%;"></div>

               <div class="text-center p-3" style="z-index:2;">
                  <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1" style="width: 280px; height: 280px;" loop autoplay></lottie-player>

                  <h6 class="fw-bold mt-3 text-dark">AI Health Companion</h6>
                  <p class="small text-muted">Join thousands of patients tracking their health daily.</p>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

  <script>
    // Year Script
    document.getElementById('year').innerText = new Date().getFullYear();

    // AOS Init
    AOS.init({ duration: 800, once: true, offset: 50 });

    // AUTH TABS LOGIC (PRESERVED)
    const tabLogin = document.getElementById('authTabLogin');
    const tabRegister = document.getElementById('authTabRegister');
    const authLogin = document.getElementById('authLogin');
    const authRegister = document.getElementById('authRegister');

    tabLogin.onclick = () => {
      tabLogin.classList.add('active'); tabRegister.classList.remove('active');
      authLogin.style.display = 'block'; authRegister.style.display = 'none';
    };
    tabRegister.onclick = () => {
      tabRegister.classList.add('active'); tabLogin.classList.remove('active');
      authRegister.style.display = 'block'; authLogin.style.display = 'none';
    };

    // Laravel Error Handling Logic (Preserved)
    @if($errors->any())
      var authModal = new bootstrap.Modal(document.getElementById('authModal'));
      authModal.show();
      @if(old('name'))
        tabRegister.click();
      @else
        tabLogin.click();
      @endif
    @endif
  </script>

</body>
</html>
