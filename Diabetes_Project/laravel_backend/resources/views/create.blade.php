<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diabetes Detection AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f4f8 0%, #d7e1ec 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 30px 0;
    }

    .main-card {
      border: none;
      box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
    }

    .card-header-custom {
      background: linear-gradient(to right, #4e73df, #224abe);
      color: white;
      padding: 30px;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.85rem;
      color: #6c757d;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Input Group Styling to make it look seamless */
    .input-group-text {
      background-color: #fff;
      border-right: none;
      color: #4e73df;
      padding-left: 20px;
      border-radius: 10px 0 0 10px !important;
    }

    .form-control {
      border-left: none;
      padding: 12px 15px;
      font-size: 0.95rem;
      border-radius: 0 10px 10px 0 !important;
    }

    /* Focus state for the whole group */
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: #4e73df;
        box-shadow: none;
    }

    .btn-gradient {
      background: linear-gradient(to right, #4e73df, #224abe);
      border: none;
      border-radius: 50px;
      padding: 12px 40px;
      font-weight: 600;
      font-size: 1rem;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
    }

    .btn-gradient:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px -10px rgba(78, 115, 223, 0.5);
      background: linear-gradient(to right, #224abe, #4e73df);
    }

    .disclaimer {
        font-size: 0.75rem;
        color: #adb5bd;
        margin-top: 25px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card main-card rounded-4 overflow-hidden">

        <div class="card-header-custom text-center">
          <i class="fa-solid fa-heart-pulse fa-3x mb-3 text-white-50"></i>
          <h2 class="fw-bold mb-1">Diabetes Detection AI</h2>
          <p class="mb-0 opacity-75 fw-light">Enter patient vitals for advanced risk assessment</p>
        </div>

        <div class="card-body p-4 p-md-5 bg-white">
          <form action="/predict" method="POST">
            @csrf

            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label">Patient Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                  <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Age (Years)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                  <input type="number" name="age" class="form-control" placeholder="e.g. 45" min="1" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Glucose Level (mg/dL)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-droplet"></i></span>
                  <input type="number" name="glucose" class="form-control" placeholder="e.g. 120" min="0" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Blood Pressure (mm Hg)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-heart-pulse"></i></span>
                  <input type="number" name="blood_pressure" class="form-control" placeholder="e.g. 80" min="0" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Skin Thickness (mm)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-ruler-vertical"></i></span>
                  <input type="number" name="skin_thickness" class="form-control" placeholder="e.g. 20" min="0" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Insulin Level (mu U/ml)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-syringe"></i></span>
                  <input type="number" name="insulin" class="form-control" placeholder="e.g. 85" min="0" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">BMI (Body Mass Index)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-weight-scale"></i></span>
                  <input type="number" step="0.1" name="bmi" class="form-control" placeholder="e.g. 33.6" min="0" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Diabetes Pedigree Function</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-dna"></i></span>
                  <input type="number" step="0.001" name="diabetes_pedigree" class="form-control" placeholder="e.g. 0.627" min="0" required>
                </div>
              </div>
            </div>

            <div class="text-center mt-5">
              <button type="submit" class="btn btn-primary btn-lg btn-gradient">
                <i class="fa-solid fa-microscope me-2"></i> Analyze & Predict Risk
              </button>
            </div>

            <p class="text-center disclaimer">
              <i class="fa-solid fa-circle-info me-1"></i> Note: This tool is for assistance only and does not replace professional medical advice.
            </p>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
