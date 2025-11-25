<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Diabetes Prediction & Patient Management</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Lottie Player -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <!-- AOS for scroll animation -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <style>
    :root{
      --brand-1: #0b6ef6;
      --brand-2: #2fd1c7;
      --muted: #f5f8fb;
      --card-shadow: 0 18px 50px rgba(12,40,80,0.06);
      --glass: rgba(255,255,255,0.72);
    }

    body {
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#f6fbff 0%, #f0f6fa 100%);
      color: #09324a;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* NAV */
    .navbar {
      background: #fff;
      box-shadow: 0 10px 30px rgba(15,40,80,0.04);
      z-index: 60;
    }
    .brand {
      display:flex; align-items:center; gap:10px; text-decoration:none; color:var(--brand-1);
    }
    .brand .logo {
      width:44px; height:44px; border-radius:10px; display:inline-grid; place-items:center;
      background: linear-gradient(135deg,var(--brand-1),var(--brand-2)); color:#fff; font-weight:800;
      box-shadow: 0 8px 30px rgba(11,110,246,0.14);
    }

    /* HERO */
    .hero { padding: 80px 0 40px; }
    .hero-card {
      background: linear-gradient(135deg,var(--brand-1),var(--brand-2));
      color: white;
      border-radius: 20px;
      padding: 44px;
      box-shadow: var(--card-shadow);
      overflow: hidden;
      position: relative;
    }
    .hero-card h1 { font-size: 42px; line-height:1.02; font-weight:800; margin-bottom:14px; }
    .hero-card p { opacity:.96; max-width:60ch; margin-bottom:22px; }
    .cta-main {
      background: white; color: var(--brand-1); font-weight:700; border-radius:12px; padding:10px 18px;
      box-shadow: 0 8px 30px rgba(12,40,80,0.08); border:none;
    }

    .hero-visual {
      border-radius: 16px;
      overflow: hidden;
      height: 360px;
      background-size: cover;
      background-position: center;
      box-shadow: 0 26px 60px rgba(8,28,60,0.12);
    }

    /* Counters */
    .counter-card {
      background: #fff; border-radius:14px; padding:20px; box-shadow: 0 8px 30px rgba(9,30,63,0.04);
      display:flex; align-items:center; gap:14px;
    }
    .counter-card .num { font-size:22px; font-weight:800; color:var(--brand-1); }

    /* Features */
    .feature {
      background: white; border-radius:12px; padding:20px; box-shadow: 0 10px 36px rgba(9,30,63,0.04);
      text-align:left;
    }
    .feature .title { font-weight:700; font-size:18px; margin-bottom:6px; }
    .feature p { color:#5d6d7a; margin-bottom:0; }

    /* Steps */
    .step {
      background: linear-gradient(90deg,#fff,#fbfeff);
      border-radius:12px; padding:18px; box-shadow: 0 8px 30px rgba(9,30,63,0.03);
    }

    /* Testimonials */
    .testimonial {
      background: white; border-radius:12px; padding:20px; box-shadow: 0 8px 30px rgba(9,30,63,0.04);
    }

    /* Footer */
    footer { padding:40px 0; color:#6b7a8a; font-size:14px; }

    /* Modal auth */
    .auth-modal .modal-content { border-radius:12px; overflow:hidden; }
    .auth-tabs { display:flex; gap:6px; margin-bottom:12px; }
    .auth-tabs button { flex:1; padding:8px 10px; border-radius:8px; border:1px solid transparent; background:#f6fbff; color:#0b2540; font-weight:700; }
    .auth-tabs button.active { background: linear-gradient(90deg,var(--brand-1),var(--brand-2)); color:#fff; box-shadow: 0 10px 30px rgba(11,110,246,0.12); }

    @media (max-width: 991px) {
      .hero-visual { height:220px; margin-top:18px; }
      .hero-card { padding:28px; border-radius:12px; }
      .hero-card h1 { font-size:28px; }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="brand" href="#">
        <div class="logo"><i class="fa-solid fa-droplet"></i></div>
        <div>
          <div style="font-weight:800;">Diabetes Care</div>
          <div style="font-size:12px;color:#7a8aa0;margin-top:2px;">Prediction & Patient Management</div>
        </div>
      </a>

      <div class="ms-auto d-flex align-items-center gap-3">
        <a class="btn btn-outline-primary" href="#overview" style="border-radius:10px;">Learn more</a>
        <button class="btn" data-bs-toggle="modal" data-bs-target="#authModal" style="background:linear-gradient(90deg,var(--brand-1),var(--brand-2)); color:#fff; border-radius:10px;">
          <i class="fa-solid fa-right-to-bracket me-2"></i> Sign in / Register
        </button>
      </div>
    </div>
  </nav>

<!-- HERO SECTION – PREMIUM VERSION -->
<section class="hero">
  <style>
    .hero-premium {
      background: linear-gradient(135deg, #0b6ef6, #0ac9b7);
      border-radius: 28px;
      padding: 90px 55px;
      box-shadow: 0 25px 70px rgba(9, 40, 90, 0.18);
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    /* Floating abstract circles */
    .hero-bubbles span {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,0.12);
      animation: rise 12s infinite ease-in-out;
      bottom: -200px;
    }
    .hero-bubbles span:nth-child(1) { left: 8%; width: 120px; height: 120px; animation-delay: 1s; }
    .hero-bubbles span:nth-child(2) { left: 35%; width: 150px; height: 150px; animation-delay: 2.5s; }
    .hero-bubbles span:nth-child(3) { left: 60%; width: 180px; height: 180px; animation-delay: 4s; }
    .hero-bubbles span:nth-child(4) { left: 85%; width: 90px; height: 90px; animation-delay: 3s; }

    @keyframes rise {
      0% { transform: translateY(0) scale(1); opacity: 0.3; }
      50% { opacity: 0.55; }
      100% { transform: translateY(-900px) scale(1.25); opacity: 0; }
    }

    .hero-title {
      font-size: 54px;
      font-weight: 800;
      line-height: 1.08;
      margin-bottom: 20px;
    }

    .hero-desc {
      font-size: 18px;
      max-width: 640px;
      opacity: 0.97;
      line-height: 1.55;
    }

    .hero-btn {
      margin-top: 30px;
      background: #fff;
      color: #0b6ef6;
      padding: 14px 32px;
      font-size: 17px;
      font-weight: 700;
      border-radius: 14px;
      border: none;
      box-shadow: 0 15px 45px rgba(255,255,255,0.25);
    }

    .hero-stats {
      margin-top: 50px;
    }

    .hero-stat-box {
      background: rgba(255,255,255,0.25);
      backdrop-filter: blur(6px);
      border-radius: 18px;
      padding: 22px 26px;
      color: #fff;
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .hero-stat-number {
      font-size: 30px;
      font-weight: 800;
    }
    .hero-stat-label {
      opacity: 0.85;
      font-size: 14px;
    }

    @media(max-width: 768px){
      .hero-title{ font-size: 34px; }
      .hero-premium{ padding: 55px 30px; }
    }
  </style>

  <div class="container">
    <div class="hero-premium" data-aos="fade-up">

      <!-- Animated bubbles -->
      <div class="hero-bubbles">
        <span></span><span></span><span></span><span></span>
      </div>

      <!-- Hero Content -->
      <div class="hero-content position-relative" style="z-index:5;">

        <h1 class="hero-title">
         Your Smart Companion for Diabetes Awareness
        </h1>

        <p class="hero-desc">
          Experience precise ML-based risk scoring, medical-grade reports,
          verified specialists, seamless appointments, and long-term patient
          tracking — all inside one beautifully crafted clinical platform.
        </p>

        <button class="hero-btn" data-bs-toggle="modal" data-bs-target="#authModal">
          Start Now — Sign In
        </button>

        <!-- Stats -->
        <div class="row hero-stats gy-4">
          <div class="col-md-3 col-6">
            <div class="hero-stat-box">
              <div class="hero-stat-number">13,524+</div>
              <div class="hero-stat-label">Patients Served</div>
            </div>
          </div>

          <div class="col-md-3 col-6">
            <div class="hero-stat-box">
              <div class="hero-stat-number">254</div>
              <div class="hero-stat-label">Verified Doctors</div>
            </div>
          </div>

          <div class="col-md-3 col-6">
            <div class="hero-stat-box">
              <div class="hero-stat-number">98.6%</div>
              <div class="hero-stat-label">Model Accuracy</div>
            </div>
          </div>

          <div class="col-md-3 col-6">
            <div class="hero-stat-box">
              <div class="hero-stat-number">4.9 ★</div>
              <div class="hero-stat-label">User Rating</div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>



          <!-- features -->
          <div class="container">
<div class="row mt-4 g-3">

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="80">
        <div class="feature d-flex align-items-center gap-3">

            <div style="text-align: center">
                <i class="fa-solid fa-chart-line fa-2x text-primary ali"></i>
                <br> <br>
                <div class="title">AI Risk Scoring</div>
                <p>Fast, explainable ML-powered predictions with next-step recommendations.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="160">
        <div class="feature d-flex align-items-center gap-3">
            <div style="text-align: center">
                 <i class="fa-solid fa-user-doctor fa-2x text-success"></i>
                 <br> <br>
                <div class="title">Verified Specialists</div>
                <p>Consult certified endocrinologists and diabetes care professionals.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="240">
        <div class="feature d-flex align-items-center gap-3">
            <div style="text-align: center">
                <i class="fa-solid fa-file-waveform fa-2x text-warning"></i>
                <br> <br>
                <div class="title">Shareable Reports</div>
                <p>Generate downloadable medical reports with charts and insights.</p>
            </div>
        </div>
    </div>

</div>
          </div>



  <!-- HOW IT WORKS -->
  <section id="how" class="py-5">
    <div class="container">
      <div class="text-center mb-4" data-aos="fade-up">
        <h3 style="font-weight:800;">How it works — in 4 simple steps</h3>
        <p class="small" style="color:#6b7a8a;">From data input to doctor consultation: designed to fit real clinical workflows.</p>
      </div>

      <div class="row g-3">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="80">
          <div class="step text-center">
            <div style="font-size:28px;color:var(--brand-1);margin-bottom:8px;"><i class="fa-solid fa-pen-nib"></i></div>
            <strong>Input measurements</strong>
            <p class="small" style="color:#6b7a8a;">Input Glucose, BMI, BP and routine info.</p>
          </div>
        </div>

        <div class="col-md-3" data-aos="fade-up" data-aos-delay="160">
          <div class="step text-center">
            <div style="font-size:28px;color:var(--brand-2);margin-bottom:8px;"><i class="fa-solid fa-robot"></i></div>
            <strong>Instant prediction</strong>
            <p class="small" style="color:#6b7a8a;">ML returns a probability and recommended action.</p>
          </div>
        </div>

        <div class="col-md-3" data-aos="fade-up" data-aos-delay="240">
          <div class="step text-center">
            <div style="font-size:28px;color:#28a745;margin-bottom:8px;"><i class="fa-solid fa-user-doctor"></i></div>
            <strong>Book a doctor</strong>
            <p class="small" style="color:#6b7a8a;">Select time, add notes, and confirm appointment.</p>
          </div>
        </div>

        <div class="col-md-3" data-aos="fade-up" data-aos-delay="320">
          <div class="step text-center">
            <div style="font-size:28px;color:#ff9800;margin-bottom:8px;"><i class="fa-solid fa-file-lines"></i></div>
            <strong>Share & follow-up</strong>
            <p class="small" style="color:#6b7a8a;">Download report PDF and track results over time.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- TESTIMONIALS & CTA -->
  <section class="py-5 bg-white">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-6" data-aos="fade-up">
          <h4 style="font-weight:800;">Trusted by patients and clinicians</h4>
          <p class="small" style="color:#6b7a8a;">We’ve helped thousands get clear next steps and book care with trusted professionals.</p>

          <div class="d-flex gap-3 mt-4">
            <div class="testimonial p-3">
              <strong>“Saved my father's life”</strong>
              <p class="small" style="color:#6b7a8a;">The prediction and quick appointment helped detect early risk.</p>
              <div class="small text-muted">— Rahim</div>
            </div>

            <div class="testimonial p-3">
              <strong>“Great for clinics”</strong>
              <p class="small" style="color:#6b7a8a;">Doctors love the concise reports and appointment flow.</p>
              <div class="small text-muted">— Dr. Nazma</div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 text-center" data-aos="fade-left">
          <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_h4th9ofg.json" background="transparent" speed="1" style="width:320px;height:320px;margin:auto;" loop autoplay></lottie-player>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <strong>Diabetes Care</strong>
          <div class="small-muted" id="yearText">© <span id="year"></span> — Built for patients & clinicians</div>
        </div>
        <div class="col-md-6 text-md-end small-muted">
          <a href="#" class="text-muted me-3">Terms</a>
          <a href="#" class="text-muted me-3">Privacy</a>
          <a href="#" class="text-muted">Contact</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- AUTH MODAL -->
  <div class="modal fade auth-modal" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-3">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6 d-flex flex-column justify-content-center">
              <h4 style="font-weight:800;">Sign in or create an account</h4>
              <p class="small" style="color:#6b7a8a;">One account to manage predictions, reports and appointments.</p>

              <div class="auth-tabs mt-3 mb-2">
                <button id="authTabLogin" class="active">Login</button>
                <button id="authTabRegister">Register</button>
              </div>

              <!-- LOGIN FORM -->
              <div id="authLogin">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" required type="email" class="form-control" placeholder="you@example.com">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" required type="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                  </div>
                </form>
              </div>

              <!-- REGISTER FORM -->
              <div id="authRegister" style="display:none;">
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Full name</label>
                    <input name="name" required type="text" class="form-control" placeholder="Your full name">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" required type="email" class="form-control" placeholder="you@example.com">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" required minlength="8" type="password" class="form-control" placeholder="Min 8 characters">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Confirm password</label>
                    <input name="password_confirmation" required type="password" class="form-control" placeholder="Repeat password">
                  </div>
                  <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create account</button>
                  </div>
                </form>
              </div>

            </div>

            <div class="col-md-6 text-center d-flex align-items-center justify-content-center">
              <!-- decorative Lottie -->
              <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_0yfsb3a1.json" background="transparent" speed="1" style="width:320px;height:320px;" loop autoplay></lottie-player>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

  <script>
    // set year
    document.getElementById('year').innerText = new Date().getFullYear();
    document.getElementById('yearText')?.querySelector('span')?.remove && document.getElementById('yearText').querySelector('span').remove();
    // AOS init
    AOS.init({ duration:700, once:true, easing:'ease-out-cubic' });

    // auth tabs
    const tabLogin = document.getElementById('authTabLogin');
    const tabRegister = document.getElementById('authTabRegister');
    const authLogin = document.getElementById('authLogin');
    const authRegister = document.getElementById('authRegister');

    tabLogin.onclick = () => {
      tabLogin.classList.add('active'); tabRegister.classList.remove('active');
      authLogin.style.display = ''; authRegister.style.display = 'none';
    };
    tabRegister.onclick = () => {
      tabRegister.classList.add('active'); tabLogin.classList.remove('active');
      authRegister.style.display = ''; authLogin.style.display = 'none';
    };

    // simple counter animation
    document.querySelectorAll('[data-count]').forEach(el => {
      const end = parseInt(el.getAttribute('data-count')) || 0;
      let start = 0;
      const step = Math.ceil(end / 60);
      const interval = setInterval(() => {
        start += step;
        if (start >= end) { el.innerText = end.toLocaleString(); clearInterval(interval); }
        else el.innerText = start.toLocaleString();
      }, 16);
    });

    // keep modal open if server-side validation errors exist (blade should print var serverHasErrors)
    @if($errors->any())
      var authModal = new bootstrap.Modal(document.getElementById('authModal'));
      authModal.show();
      // optionally switch to register if errors contain password_confirmation or name
      @if(old('name'))
        tabRegister.click();
      @else
        tabLogin.click();
      @endif
    @endif
  </script>

</body>
</html>
