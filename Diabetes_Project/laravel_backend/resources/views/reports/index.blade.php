@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Reports</h2>

    <form method="GET" action="{{ route('reports.index') }}" class="mb-3 d-flex">
        <input type="text" name="q" class="form-control me-2" placeholder="Search by patient name" value="{{ request('q') }}">
        <button class="btn btn-primary">Search</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Age</th>
                <th>Predictions (sample)</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $patient)
                @php $res = $patient->result ?? []; @endphp
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>
                        @if(isset($res['predictions']))
                            @foreach($res['predictions'] as $m => $p)
                                <div><strong>{{ $m }}:</strong> {{ $p }}</div>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $patient->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('patients.download', $patient->id) }}" class="btn btn-sm btn-outline-primary mb-1">Download</a>

                        <form action="{{ route('reports.destroy', $patient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete report?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete Report</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $reports->links('pagination::bootstrap-5') }}
</div>
@endsection
