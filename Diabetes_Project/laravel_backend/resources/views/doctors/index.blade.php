@extends('layouts.app')

@section('title', 'Medical Staff')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Specialist Doctors</h4>
                    <p class="small text-muted mb-0">Manage your medical team and their permissions.</p>
                </div>

                <div class="d-flex gap-2 w-100 w-md-auto">
                    <form action="{{ route('doctors.index') }}" method="GET" class="position-relative flex-grow-1">
                        <i class="fa-solid fa-search text-muted position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); font-size: 14px;"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               class="form-control ps-5 rounded-pill border-0 shadow-sm"
                               placeholder="Search doctor..."
                               style="padding-top: 10px; padding-bottom: 10px; min-width: 250px;">
                    </form>

                    <a href="{{ route('doctors.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                        <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline">Add New</span>
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold" style="width: 5%;">#</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 30%;">Doctor Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 25%;">Specialization</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 20%;">Contact Info</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-end pe-4" style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doctors as $doctor)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ substr($doctor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $doctor->name }}</div>
                                            <div class="small text-muted">{{ $doctor->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                                        {{ $doctor->specialization }}
                                    </span>
                                </td>

                                <td>
                                    @if($doctor->phone)
                                        <div class="d-flex align-items-center gap-2 text-muted small fw-bold">
                                            <i class="fa-solid fa-phone text-secondary"></i> {{ $doctor->phone }}
                                        </div>
                                    @else
                                        <span class="text-muted small opacity-50">Not Available</span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-light border text-dark" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light border text-danger" onclick="return confirm('Are you sure you want to remove this doctor?')" data-bs-toggle="tooltip" title="Delete">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-user-doctor fa-2x text-muted opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No Doctors Found</h5>
                                        <p class="text-muted small">Get started by adding a new specialist to the system.</p>
                                        <a href="{{ route('doctors.create') }}" class="btn btn-sm btn-primary px-4 rounded-pill">Add Doctor</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($doctors->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $doctors->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }
    .table-hover tbody tr:hover { background-color: #f8faff; transition: all 0.2s ease-in-out; }
    .form-control:focus { box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15); border-color: #4361ee; }
</style>
@endsection
