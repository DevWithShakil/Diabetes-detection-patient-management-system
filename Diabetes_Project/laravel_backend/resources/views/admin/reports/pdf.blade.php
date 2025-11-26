<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master Medical Report</title>
    <style>
        @font-face { font-family: 'Roboto'; src: url('https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4mxK.woff2') format('woff2'); }
        body { font-family: 'Roboto', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }

        /* Layout & Headers */
        .header { background: #1e293b; color: white; padding: 20px; text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .section-title { font-size: 14px; font-weight: bold; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; margin-bottom: 15px; color: #1e40af; text-transform: uppercase; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #e2e8f0; text-align: left; }
        th { background: #f1f5f9; color: #475569; }

        /* Badges & Bars */
        .badge { padding: 4px 8px; border-radius: 4px; color: white; font-weight: bold; font-size: 10px; }
        .bg-danger { background: #ef4444; } .bg-success { background: #10b981; }
        .progress-bg { background: #e2e8f0; height: 8px; width: 100%; border-radius: 4px; }
        .progress-bar { height: 100%; background: #3b82f6; border-radius: 4px; }

        /* Page Break */
        .page-break { page-break-after: always; }

        /* Advice Box */
        .advice-box { background: #f8fafc; padding: 20px; border: 1px solid #cbd5e1; border-radius: 8px; }
        .advice-list li { margin-bottom: 8px; }
    </style>
</head>
<body>

    @php
        $result = json_decode($patient->result, true);
        $accuracies = $result['accuracies'] ?? [];

        // Voting Logic to determine final status
        $finalPrediction = 'Pending';
        if (isset($result['predictions']) && is_array($result['predictions'])) {
            $votes = collect($result['predictions'])->map(fn($v) => strtolower(trim($v)));
            $diabeticCount = $votes->filter(fn($v) => $v === 'diabetic')->count();
            $nonCount = $votes->filter(fn($v) => $v === 'non-diabetic')->count();
            $finalPrediction = ($diabeticCount > $nonCount) ? 'Diabetic' : 'Non-Diabetic';
        }
    @endphp

    <div class="header">
        <h1>CONFIDENTIAL MEDICAL ANALYSIS</h1>
        <p>Internal Report for Doctors & Administrators</p>
    </div>

    <div class="section-title">Patient Demographics</div>
    <table>
        <tr>
            <td><strong>Name:</strong> {{ $patient->name }}</td>
            <td><strong>Age:</strong> {{ $patient->age }} Years</td>
            <td><strong>ID:</strong> #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td><strong>Glucose:</strong> {{ $patient->glucose }} mg/dL</td>
            <td><strong>BMI:</strong> {{ $patient->bmi }}</td>
            <td><strong>Blood Pressure:</strong> {{ $patient->blood_pressure }}</td>
        </tr>
    </table>

    <div class="section-title">Machine Learning Model Breakdown</div>
    <p style="font-size: 11px; color: #64748b; margin-bottom: 15px;">
        This section details the confidence score of each algorithm used in the diagnosis.
    </p>

    <table>
        <thead>
            <tr>
                <th width="40%">Algorithm Model</th>
                <th width="20%">Prediction</th>
                <th width="40%">Confidence Score (Accuracy)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accuracies as $model => $score)
                @php
                    $pred = $result['predictions'][$model] ?? 'N/A';
                    $isDiabetic = strtolower($pred) === 'diabetic';
                @endphp
                <tr>
                    <td><strong>{{ $model }}</strong></td>
                    <td>
                        <span class="badge {{ $isDiabetic ? 'bg-danger' : 'bg-success' }}">
                            {{ $pred }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="progress-bg" style="width: 70%; float: left; margin-top: 4px;">
                                <div class="progress-bar" style="width: {{ $score }}%;"></div>
                            </div>
                            <span style="float: right; width: 25%;">{{ $score }}%</span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; padding: 10px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a;">
        <strong>Final Consensus:</strong> Based on majority voting, the patient is diagnosed as
        <strong style="text-transform: uppercase; text-decoration: underline;">{{ $finalPrediction }}</strong>.
    </div>

    <div class="page-break"></div>

    <div class="header" style="background: #0f766e;">
        <h1>PATIENT CARE PLAN</h1>
        <p>Generated Advice & Lifestyle Recommendations</p>
    </div>

    <div class="section-title">Diagnosis Result Summary</div>

    @if($finalPrediction === 'Diabetic')
        <div style="padding: 20px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 8px; text-align: center; margin-bottom: 30px;">
            <h2 style="margin: 0;">⚠️ High Risk Detected</h2>
            <p>Your vitals suggest a strong indication of Diabetes.</p>
        </div>

        <div class="section-title">Recommended Action Plan</div>
        <div class="advice-box">
            <ul class="advice-list">
                <li><strong>Immediate Consultation:</strong> Please schedule a visit with an Endocrinologist within 3 days.</li>
                <li><strong>Dietary Changes:</strong> Reduce carbohydrate intake (rice, bread, sugar). Increase fiber (vegetables, salads).</li>
                <li><strong>Physical Activity:</strong> Engage in at least 30 minutes of brisk walking daily.</li>
                <li><strong>Medication:</strong> Do not start any medication without a doctor's prescription.</li>
            </ul>
        </div>

    @else
        <div style="padding: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 8px; text-align: center; margin-bottom: 30px;">
            <h2 style="margin: 0;">✅ Low Risk (Healthy)</h2>
            <p>Great news! Your vitals are currently within the safe range.</p>
        </div>

        <div class="section-title">Prevention & Maintenance</div>
        <div class="advice-box">
            <ul class="advice-list">
                <li><strong>Maintain Weight:</strong> Keep your BMI within the 18.5 - 24.9 range.</li>
                <li><strong>Balanced Diet:</strong> Avoid processed foods and sugary drinks to prevent future risks.</li>
                <li><strong>Regular Screening:</strong> Since prevention is better than cure, check your glucose levels every 6 months.</li>
                <li><strong>Hydration:</strong> Drink 8-10 glasses of water daily.</li>
            </ul>
        </div>
    @endif

    <div style="margin-top: 50px; text-align: center; color: #94a3b8; font-size: 10px;">
        Report Generated by Diabetes Care AI System • Verified by Admin Panel
    </div>

</body>
</html>
