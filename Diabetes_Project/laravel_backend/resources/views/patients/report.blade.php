<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Medical Analysis Report - {{ $patient->name }}</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0; padding: 0;
            color: #334155;
            line-height: 1.6;
        }

        /* --- Header --- */
        .header-bar {
            background: #0d6efd;
            color: white;
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-name {
            font-size: 22px; font-weight: 700; letter-spacing: 1px;
        }
        .report-title {
            text-align: right;
        }
        .report-title h2 {
            margin: 0; font-size: 18px; font-weight: 600; text-transform: uppercase;
        }
        .report-title p {
            margin: 5px 0 0; font-size: 12px; opacity: 0.8;
        }

        /* --- Main Container --- */
        .container {
            padding: 40px;
        }

        /* --- Section Titles --- */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #0d6efd;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 25px;
            margin-top: 40px;
        }
        .section-title:first-child { margin-top: 0; }

        /* --- Patient Info Grid (Modern) --- */
        .info-grid {
            display: table; width: 100%; border-collapse: collapse; margin-bottom: 30px;
        }
        .info-row { display: table-row; }
        .info-cell {
            display: table-cell; width: 25%; padding: 15px;
            border: 1px solid #e2e8f0; background: #f8fafc;
        }
        .info-label {
            display: block; font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 600; mb-1;
        }
        .info-value {
            font-size: 14px; font-weight: 600; color: #1e293b;
        }

        /* --- Tables (Modern) --- */
        .modern-table {
            width: 100%; border-collapse: collapse; margin-top: 15px;
        }
        .modern-table th {
            text-align: left; background: #f1f5f9; color: #475569;
            font-weight: 600; font-size: 12px; text-transform: uppercase;
            padding: 12px 15px; border-bottom: 2px solid #e2e8f0;
        }
        .modern-table td {
            padding: 12px 15px; border-bottom: 1px solid #e2e8f0; font-size: 14px;
        }
        .modern-table tr:last-child td { border-bottom: none; }

        /* --- Status Badges --- */
        .badge {
            padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase;
        }
        .badge-diabetic { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-healthy { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        /* --- Footer --- */
        .footer-bar {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #f8fafc; padding: 20px 40px;
            text-align: center; font-size: 11px; color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

    <div class="header-bar">
        <div class="brand-name">DIABETES CARE</div>
        <div class="report-title">
            <h2>Clinical Analysis Report</h2>
            <p>Report ID: #{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }} | Date: {{ now()->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="container">

        <div class="section-title">Patient Vitals & Demographics</div>

        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <span class="info-label">Patient Name</span>
                    <span class="info-value">{{ $patient->name }}</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">Age</span>
                    <span class="info-value">{{ $patient->age }} Yrs</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">BMI (Body Mass Index)</span>
                    <span class="info-value">{{ $patient->bmi }}</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">Blood Pressure</span>
                    <span class="info-value">{{ $patient->blood_pressure }} mm Hg</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell">
                    <span class="info-label">Glucose Level</span>
                    <span class="info-value">{{ $patient->glucose }} mg/dL</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">Insulin Level</span>
                    <span class="info-value">{{ $patient->insulin }} mu U/ml</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">Skin Thickness</span>
                    <span class="info-value">{{ $patient->skin_thickness }} mm</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">Diabetes Pedigree</span>
                    <span class="info-value">{{ $patient->diabetes_pedigree }}</span>
                </div>
            </div>
        </div>

        @php
            // Decode result safely
            $result = is_array($patient->result) ? $patient->result : json_decode($patient->result, true);
        @endphp

        @if($result)
            <div style="page-break-inside: avoid;">
                <div class="section-title" style="margin-top: 40px;">AI Prediction Analysis</div>

                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="40%">Machine Learning Model</th>
                            <th width="30%">Model Accuracy</th>
                            <th width="30%">Prediction Outcome</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result['predictions'] ?? [] as $model => $prediction)
                            @php
                                $accuracy = $result['accuracies'][$model] ?? 'N/A';
                                $isDiabetic = strtolower($prediction) === 'diabetic';
                            @endphp
                            <tr>
                                <td style="font-weight: 600; color: #334155;">{{ $model }} Algorithm</td>
                                <td style="font-weight: 600; color: #0d6efd;">{{ $accuracy }}% Confident</td>
                                <td>
                                    <span class="badge {{ $isDiabetic ? 'badge-diabetic' : 'badge-healthy' }}">
                                        {{ $prediction }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div style="margin-top: 40px; padding: 15px; background: #f1f5f9; border-left: 4px solid #64748b; font-size: 11px; color: #475569;">
            <strong>Disclaimer:</strong> This report is generated by artificial intelligence for screening purposes only. It is not a definitive medical diagnosis. Please consult a certified endocrinologist for clinical validation and treatment planning.
        </div>

    </div>

    <div class="footer-bar">
        Generated by Diabetes Care AI System &bull; {{ now()->format('F d, Y - h:i A') }} &bull; This document is confidential.
    </div>

</body>
</html>
