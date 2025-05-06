@extends('layouts.admin.app')

@section('header')
Doctors
@endsection

@section('content')

<!-- Add this line to include the CSS -->
<link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}">

<div class="container">
    <!-- Add Doctor Button -->
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn" style="background-color: #e12454; color: white;" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
        <i class="fas fa-plus"></i>Add Doctor
        </button>
    </div>

    <!-- Search and Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('doctors.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search doctors..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="specialization_id">
                        <option value="all" {{ request('specialization_id') == 'all' ? 'selected' : '' }}>All Specializations</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization->id }}" {{ request('specialization_id') == $specialization->id ? 'selected' : '' }}>
                                {{ $specialization->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Governorate</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <td>{{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if(isset($doctor->image) && $doctor->image)
                                <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}" class="rounded-circle me-2" width="32" height="32">
                            @else
                                <div class="avatar-placeholder rounded-circle me-2" style="width: 32px; height: 32px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-md text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <strong class="d-block">{{ $doctor->name }}</strong>
                                <small class="text-muted">{{ $doctor->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $doctor->specialization->name ?? 'N/A' }}</td>
                    <td>{{ $doctor->governorate ?? 'N/A' }}</td>
                    <td>{{ number_format($doctor->price_per_appointment ?? 0, 2) }} JOD</td>
                    <td>
                        <span class="badge rounded-pill" 
                              style="background-color: {{ $doctor->status === 'approved' ? '#10b981' : ($doctor->status === 'rejected' ? '#ef4444' : '#f59e0b') }}; 
                                     color: white; 
                                     padding: 0.25rem 0.5rem; 
                                     font-size: 0.75rem;">
                            {{ ucfirst($doctor->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @if($doctor->status === 'pending')
                                <form action="{{ route('admin.doctors.update-status', $doctor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm" style="background-color: #10b981; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.doctors.update-status', $doctor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm" style="background-color: #ef4444; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-sm" style="background-color: #3b82f6; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#2563eb'" onmouseout="this.style.backgroundColor='#3b82f6'">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm" style="background-color: #223a66; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#1a2d52'" onmouseout="this.style.backgroundColor='#223a66'">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #dc2626; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'" onclick="return confirm('Are you sure you want to delete this doctor?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $doctors->appends(request()->query())->links() }}
    </div>
</div>

<!-- Add Doctor Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDoctorModalLabel">Add New Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialization_id" class="form-label">Specialization</label>
                                <select class="form-select" id="specialization_id" name="specialization_id" required>
                                    <option value="">Select Specialization</option>
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="governorate" class="form-label">Governorate</label>
                                <input type="text" class="form-control" id="governorate" name="governorate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price_per_appointment" class="form-label">Price Per Appointment (JOD)</label>
                                <input type="number" step="0.01" class="form-control" id="price_per_appointment" name="price_per_appointment" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_document" class="form-label">Doctor Document</label>
                        <input type="file" class="form-control" id="doctor_document" name="doctor_document" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Working Days</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="monday" id="monday">
                                <label class="form-check-label" for="monday">Monday</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tuesday" id="tuesday">
                                <label class="form-check-label" for="tuesday">Tuesday</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="wednesday" id="wednesday">
                                <label class="form-check-label" for="wednesday">Wednesday</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="thursday" id="thursday">
                                <label class="form-check-label" for="thursday">Thursday</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="friday" id="friday">
                                <label class="form-check-label" for="friday">Friday</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="saturday" id="saturday">
                                <label class="form-check-label" for="saturday">Saturday</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sunday" id="sunday">
                                <label class="form-check-label" for="sunday">Sunday</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Doctor</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
    }
    .badge {
        font-size: 0.85em;
    }
    .document-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }
    .form-check {
        min-width: 100px;
    }
</style>
@endsection

@section('scripts')
@if(session('success'))
<script>
    Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
    });
</script>
@endif
@if(session('error'))
<script>
    Toast.fire({
        icon: 'error',
        title: '{{ session('error') }}'
    });
</script>
@endif
@endsection
