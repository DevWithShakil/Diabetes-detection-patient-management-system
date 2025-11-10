<!DOCTYPE html>
<html>
<head>
    <title>Patient Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Patient Report</h2>
    <p><strong>Name:</strong> {{ $patient->name }}</p>
    <p><strong>Age:</strong> {{ $patient->age }}</p>
    <p><strong>Glucose:</strong> {{ $patient->glucose }}</p>

    @if(isset($patient->result))
        <h3>Model Predictions</h3>
        <table>
            <tr>
                <th>Model</th>
                <th>Prediction</th>
                <th>Accuracy</th>
            </tr>
            @foreach($patient->result['predictions'] ?? [] as $model => $prediction)
                <tr>
                    <td>{{ $model }}</td>
                    <td>{{ $prediction }}</td>
                    <td>{{ $patient->result['accuracies'][$model] ?? '—' }}%</td>
                </tr>
            @endforeach
        </table>
    @endif
</body>
</html>
