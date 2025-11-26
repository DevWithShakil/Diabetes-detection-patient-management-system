<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Medical Analysis Report</title>
    <style>
        /* PDF Compatible Fonts & Reset */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4mxK.woff2) format('woff2');
        }

        body {
            font-family: 'Roboto', 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }

        /* --- Header Section --- */
        .header {
            background-color: #0f172a; /* Deep Navy */
            color: #ffffff;
            padding: 30px 40px;
            border-bottom: 5px solid #3b82f6; /* Accent Blue */
        }
        .header-table {
            width: 100%;
            border: none;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .report-label {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: #94a3b8;
        }
        .report-date {
            text-align: right;
            font-size: 12px;
            margin-top: 5px;
            color: #cbd5e1;
        }

        /* --- Patient Info Section --- */
        .info-wrapper {
            padding: 30px 40px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-title {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #475569;
            width: 120px;
        }
        .value {
            color: #0f172a;
            font-weight: 500;
        }

        /* --- Results Section --- */
        .content {
            padding: 30px 40px;
        }
        .section-heading {
            font-size: 16px;
            font-weight: bold;
            color: #3b82f6;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* --- Custom Table Style --- */
        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .result-table th {
            background-color: #eff6ff;
            color: #1e40af;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: bold;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #bfdbfe;
        }
        .result-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }
        .result-table tr:last-child td {
            border-bottom: none;
        }

        /* --- Badges --- */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* --- Footer --- */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 40px;
            background-color: #fff;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-name">DIABETES CARE</div>
                    <div style="font-size: 11px; opacity: 0.8;">Advanced AI Diagnostics Center</div>
                </td>
                <td>
                    <div class="report-label">Confidential Report</div>
                    <div class="report-date">Generated: {{ date('F d, Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-wrapper">
        <div class="info-title">Patient Profile</div>
        <table class="info-table">
            <tr>
                <td width="50%">
                    <table width="100%">
                        <tr>
                            <td class="label">Patient Name:</td>
                            <td class="value">{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <td class="label">Patient ID:</td>
                            <td class="value">#{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table width="100%">
                        <tr>
                            <td class="label">Age:</td>
                            <td class="value">{{ $patient->age }} Years</td>
                        </tr>
                        <tr>
                            <td class="label">Glucose Level:</td>
                            <td class="value">{{ $patient->glucose }} mg/dL</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">

        @php
            // Safe JSON decoding
            $result = is_array($patient->result) ? $patient->result : json_decode($patient->result, true);
        @endphp

        @if($result)
            <div class="section-heading">AI Analysis Results</div>

            <table class="result-table">
                <thead>
                    <tr>
                        <th width="40%">Analysis Model</th>
                        <th width="30%">Prediction Outcome</th>
                        <th width="30%">Model Confidence</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result['predictions'] ?? [] as $model => $prediction)
                        @php
                            $isDiabetic = strtolower($prediction) === 'diabetic';
                            $accuracy = $result['accuracies'][$model] ?? 'N/A';
                        @endphp
                        <tr>
                            <td style="font-weight: bold; color: #334155;">
                                {{ $model }} Algorithm
                            </td>
                            <td>
                                <span class="badge {{ $isDiabetic ? 'badge-danger' : 'badge-success' }}">
                                    {{ $prediction }}
                                </span>
                            </td>
                            <td style="color: #64748b;">
                                {{ $accuracy }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 40px; padding: 15px; background: #f8fafc; border-left: 4px solid #94a3b8; color: #64748b; font-size: 11px;">
                <strong>Note:</strong> This report is generated by Artificial Intelligence based on the provided vital signs. It is intended for screening purposes only and must be verified by a certified medical professional.
            </div>
        @else
            <div style="padding: 20px; text-align: center; color: #94a3b8; background: #f8fafc; border-radius: 5px;">
                No prediction data available for this patient.
            </div>
        @endif
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Diabetes Care AI System. All rights reserved. <br>
        This document contains sensitive medical information.
    </div>

</body>
</html>
