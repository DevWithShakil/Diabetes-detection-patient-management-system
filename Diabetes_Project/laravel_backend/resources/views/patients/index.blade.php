{{-- @extends('layouts.app')
@section('content')
<div class="container">
  <div class="mb-3">
    <a href="{{ route('patients.create') }}" class="btn btn-success">New Patient</a>
  </div>
  <table class="table table-bordered">
    <thead><tr><th>#</th><th>Name</th><th>Age</th><th>Result</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      @foreach($patients as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->age }}</td>
        <td>
          @php $pred = $p->result['predictions'] ?? []; $major = collect($pred)->filter(fn($v)=>$v==='Diabetic')->count() >= ceil(count($pred)/2); @endphp
          <span class="{{ $major ? 'text-danger' : 'text-success' }}">{{ $major ? 'Diabetic' : 'Non-Diabetic' }}</span>
        </td>
        <td>{{ $p->created_at->format('Y-m-d') }}</td>
        <td>
          <a href="{{ route('patients.show', $p) }}" class="btn btn-sm btn-info">View</a>
          <a href="{{ route('patients.download',$p) }}" class="btn btn-sm btn-secondary">PDF</a>
          <form action="{{ route('patients.destroy',$p) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Del</button></form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $patients->links() }}
</div>
@endsection --}}


@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">All Patients</h2>

    <form method="GET" action="{{ route('patients.index') }}" class="mb-3 d-flex">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control me-2" placeholder="Search patient">
        <button class="btn btn-primary">Search</button>
    </form>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Age</th>
                <th>Glucose</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->glucose }}</td>
                <td>{{ $patient->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('patients.download', $patient->id) }}" class="btn btn-sm btn-outline-primary">Download</a>

                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete patient?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $patients->links('pagination::bootstrap-5') }}
</div>
@endsection

