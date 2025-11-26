<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diabetes Detection AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f4f8 0%, #d7e1ec 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 20px 0;
    }

    .main-card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .card-header-custom {
      background: linear-gradient(to right, #0d6efd, #0a58ca);
      color: white;
      padding: 25px 20px;
      text-align: center;
    }

    .form-label {
      font-weight: 500;
      font-size: 0.9rem;
      color: #555;
      margin-bottom: 8px;
    }

    .input-group-text {
      background-color: #f8f9fa;
      border-color: #dee2e6;
      color: #0d6efd;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #0d6efd;
    }

    .form-control {
        padding: 10px 15px;
        font-size: 0.95rem;
    }

    .btn-predict {
      background: linear-gradient(to right, #0d6efd, #0a58ca);
      border: none;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s ease;
    }

    .btn-predict:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
      background: linear-gradient(to right, #0a58ca, #084298);
    }

    .disclaimer {
        font-size: 0.8rem;
        color: #888;
        text-align: center;
        margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card main-card">
        <div class="card-header-custom">
          <h2 class="mb-1"><i class="fa-solid fa-heart-pulse me-2"></i>Diabetes Detection AI</h2>
          <p class="mb-0 opacity-75">Enter patient details below for risk assessment</p>
        </div>

        <div class="card-body p-4 p-md-5">
          <form action="/predict" method="POST">
            {{-- @csrf --}}

            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label">Patient Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                  <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Age (years)</label>
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
              <button type="submit" class="btn btn-primary btn-lg btn-predict w-100 w-md-auto">
                <i class="fa-solid fa-stethoscope me-2"></i> Analyze & Predict
              </button>
            </div>

            <p class="disclaimer">Note: This tool is for assistance only and does not replace professional medical advice.</p>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
