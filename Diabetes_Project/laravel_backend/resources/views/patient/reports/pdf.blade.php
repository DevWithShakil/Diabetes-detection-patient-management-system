<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Personal Health Report - {{ $patient->name }}</title>
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url('https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4mxK.woff2') format('woff2');
        }
        body {
            font-family: 'Roboto', Helvetica, Arial, sans-serif;
            margin: 0; padding: 0; color: #333; line-height: 1.6; font-size: 14px;
        }

        /* Header */
        .header {
            background-color: #0f172a; color: #fff; padding: 30px 40px;
            border-bottom: 5px solid #3b82f6;
        }
        .company-name { font-size: 24px; font-weight: bold; text-transform: uppercase; }
        .report-meta { text-align: right; color: #cbd5e1; font-size: 12px; }

        /* Patient Info */
        .section { padding: 30px 40px; }
        .section-title {
            font-size: 16px; font-weight: bold; color: #3b82f6;
            border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 20px;
            text-transform: uppercase;
        }
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-grid td { padding: 8px 0; width: 50%; vertical-align: top; }
        .label { font-weight: bold; color: #64748b; width: 120px; display: inline-block; }

        /* Result Banner */
        .result-box {
            padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0;
            border: 1px solid;
        }
        .result-diabetic {
            background-color: #fef2f2; border-color: #fecaca; color: #991b1b;
        }
        .result-healthy {
            background-color: #f0fdf4; border-color: #bbf7d0; color: #166534;
        }
        .result-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
        .result-desc { font-size: 13px; opacity: 0.9; }

        /* Advice Section */
        .advice-box {
            background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px;
        }
        .advice-list { margin: 0; padding-left: 20px; }
        .advice-list li { margin-bottom: 8px; color: #475569; }

        /* Footer */
        .footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            padding: 20px 40px; background: #fff; border-top: 1px solid #e2e8f0;
            text-align: center; font-size: 10px; color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <div class="company-name">DIABETES CARE</div>
                    <div style="font-size: 11px; opacity: 0.8;">AI-Powered Health Analysis</div>
                </td>
                <td class="report-meta">
                    <div>Patient Report ID: #{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div>Date: {{ date('F d, Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Patient Profile</div>
        <table class="info-grid">
            <tr>
                <td>
                    <span class="label">Name:</span> {{ $patient->name }}<br>
                    <span class="label">Age:</span> {{ $patient->age }} Years<br>
                    <span class="label">BMI:</span> {{ $patient->bmi }}
                </td>
                <td>
                    <span class="label">Glucose:</span> {{ $patient->glucose }} mg/dL<br>
                    <span class="label">Blood Pressure:</span> {{ $patient->blood_pressure }} mm Hg<br>
                    <span class="label">Insulin:</span> {{ $patient->insulin }} mu U/ml
                </td>
            </tr>
        </table>

        @php
            $report = is_array($patient->result) ? $patient->result : json_decode($patient->result, true);
            $finalPrediction = null;

            if (isset($report['predictions']) && is_array($report['predictions'])) {
                $votes = collect($report['predictions'])->map(fn($v) => strtolower(trim($v)));
                $diabeticVotes = $votes->filter(fn($v) => $v === 'diabetic')->count();
                $nonVotes = $votes->filter(fn($v) => $v === 'non-diabetic')->count();
                if ($diabeticVotes > $nonVotes) $finalPrediction = 'Diabetic';
                elseif ($nonVotes > $diabeticVotes) $finalPrediction = 'Non-Diabetic';
            }
        @endphp

        @if($finalPrediction === 'Diabetic')
            <div class="result-box result-diabetic">
                <div class="result-title">⚠️ Indication: High Risk of Diabetes</div>
                <div class="result-desc">
                    Based on your provided vitals, our analysis suggests a high probability of diabetes.
                    Please consult with your assigned doctor for further clinical tests.
                </div>
            </div>

            <div class="section-title" style="margin-top: 30px;">Recommended Lifestyle Changes</div>
            <div class="advice-box">
                <ul class="advice-list">
                    <li><strong>Diet Control:</strong> Reduce sugar and refined carbohydrates (white rice, bread). Focus on whole grains and leafy vegetables.</li>
                    <li><strong>Regular Exercise:</strong> Aim for at least 30 minutes of moderate activity (like walking) daily.</li>
                    <li><strong>Monitor Blood Sugar:</strong> Keep track of your glucose levels regularly as advised by your doctor.</li>
                    <li><strong>Hydration:</strong> Drink plenty of water and avoid sugary drinks or soda.</li>
                    <li><strong>Stress Management:</strong> High stress can affect blood sugar. Practice yoga or meditation.</li>
                </ul>
            </div>

        @elseif($finalPrediction === 'Non-Diabetic')
            <div class="result-box result-healthy">
                <div class="result-title">✅ Result: Low Risk (Non-Diabetic)</div>
                <div class="result-desc">
                    Great news! Your vitals indicate a healthy range.
                    However, maintaining a healthy lifestyle is key to prevention.
                </div>
            </div>

            <div class="section-title" style="margin-top: 30px;">Tips to Stay Healthy</div>
            <div class="advice-box">
                <ul class="advice-list">
                    <li><strong>Balanced Diet:</strong> Continue eating a mix of proteins, fiber, and healthy fats.</li>
                    <li><strong>Stay Active:</strong> Physical activity helps maintain insulin sensitivity. Keep moving!</li>
                    <li><strong>Regular Checkups:</strong> Even if healthy, an annual checkup is recommended to track vitals.</li>
                    <li><strong>Sleep Well:</strong> Ensure 7-8 hours of quality sleep to regulate body hormones.</li>
                </ul>
            </div>
        @else
            <div class="result-box" style="background: #f1f5f9; border-color: #e2e8f0;">
                <div class="result-title">Analysis Pending</div>
                <div class="result-desc">Please wait for the doctor to review your data.</div>
            </div>
        @endif

        <div style="margin-top: 40px; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 10px;">
            <strong>Medical Disclaimer:</strong> This report provides health recommendations based on AI analysis and general medical guidelines. It is not a substitute for professional medical advice, diagnosis, or treatment. Always seek the advice of your physician.
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Diabetes Care AI System. All rights reserved.
    </div>

</body>
</html>
