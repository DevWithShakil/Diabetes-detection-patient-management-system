@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card p-4 shadow-sm">

    <h3>{{ $patient->name }}</h3>
    <p class="text-muted">
        Age: <strong>{{ $patient->age }}</strong>
        &nbsp; | &nbsp;
        BMI: <strong>{{ $patient->bmi }}</strong>
    </p>

    @php
        // Convert JSON text → array
        $result = json_decode($patient->result, true);

        // Protect against null
        $predictions = $result['predictions'] ?? [];
    @endphp

    <h5 class="mt-4 mb-3 fw-bold">Model Predictions</h5>

    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
            <th>Model</th>
            <th>Prediction</th>
        </tr>
      </thead>
      <tbody>
        @forelse($predictions as $model => $pred)
        <tr>
            <td>{{ $model }}</td>

            <td>
                @if(strtolower($pred) == "diabetic")
                    <span class="badge bg-danger">Diabetic</span>
                @else
                    <span class="badge bg-success">Non-Diabetic</span>
                @endif
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No prediction data available.</td>
            </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('patients.report', $patient->id) }}" class="btn btn-primary">
            Download PDF
        </a>
    </div>

  </div>
</div>
@endsection
