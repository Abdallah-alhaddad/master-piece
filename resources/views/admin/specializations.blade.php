@extends('layouts.admin.app')

@section('header')
Specializations
@endsection

@section('content')

<!-- Add this line to include the CSS -->
<link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}">

<!-- Button to Trigger the Modal -->
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn" style="background-color: #e12454; color: white;"data-bs-toggle="modal" data-bs-target="#addSpecializationModal">
    <i class="fas fa-plus"></i>
        Add Specialization
    </button>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('specializations.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search specializations..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <a href="{{ route('specializations.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>



<!-- Add Specialization Modal -->
<div class="modal fade" id="addSpecializationModal" tabindex="-1" aria-labelledby="addSpecializationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSpecializationModalLabel">Add New Specialization</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('specializations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter specialization name" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Specialization</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Specializations Table -->
<div class="container">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specializations as $specialization)
                <tr>
                    <td>{{ ($specializations->currentPage() - 1) * $specializations->perPage() + $loop->iteration }}</td>
                    <td>{{ $specialization->name }}</td>
                    <td>{{ $specialization->description }}</td>
                    <td>{{ $specialization->created_by ? \App\Models\Admin::find($specialization->created_by)->name : 'N/A' }}</td>
                    <td>{{ $specialization->created_at }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm" style="background-color: #223a66; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#1a2d52'" onmouseout="this.style.backgroundColor='#223a66'" data-bs-toggle="modal" data-bs-target="#editModal-{{ $specialization->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-sm" style="background-color: #dc2626; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $specialization->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $specializations->appends(request()->query())->links() }}
    </div>
</div>

@endsection