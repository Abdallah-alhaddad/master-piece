@extends('layouts.admin.app')

@section('header')
Admins Management
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}">



<!-- Add Admin Button -->
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn" style="background-color: #e12454; color: white;" data-bs-toggle="modal" data-bs-target="#addAdminModal">
        <i class="fas fa-plus"></i> Add Admin
    </button>
</div>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admins.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
                    </div>

                    


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Admins Table -->
<div class="container">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->phone }}</td>
                    <td>
                        <span class="badge
                            @if($admin->role == 'super_admin') bg-danger
                            @else bg-primary
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                        </span>
                    </td>
                    <td>
                        @if($admin->trashed())
                            <span class="badge bg-secondary">Archived</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @if($admin->trashed())
                                <!-- Restore Button -->
                                <form action="{{ route('admins.restore', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm" style="background-color: #10b981; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'" title="Restore">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            @else
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm" style="background-color: #223a66; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#1a2d52'" onmouseout="this.style.backgroundColor='#223a66'" data-bs-toggle="modal" data-bs-target="#editModal-{{ $admin->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif

                            <!-- Delete/Archive Button -->
                            <button type="button" class="btn btn-sm" style="background-color: #dc2626; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s ease-in-out; font-size: 0.75rem;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $admin->id }}" title="{{ $admin->trashed() ? 'Permanently Delete' : 'Archive' }}">
                                <i class="fas {{ $admin->trashed() ? 'fa-trash' : 'fa-archive' }}"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Edit Admin Modal -->
                <div class="modal fade" id="editModal-{{ $admin->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $admin->id }}">Edit Admin: {{ $admin->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admins.update', $admin->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name-{{ $admin->id }}" class="form-label">Name *</label>
                                        <input type="text" class="form-control" id="name-{{ $admin->id }}" name="name" value="{{ $admin->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email-{{ $admin->id }}" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email-{{ $admin->id }}" name="email" value="{{ $admin->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone-{{ $admin->id }}" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone-{{ $admin->id }}" name="phone" value="{{ $admin->phone }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="role-{{ $admin->id }}" class="form-label">Role *</label>
                                        <select class="form-select" id="role-{{ $admin->id }}" name="role" required>
                                            <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="super_admin" {{ $admin->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal-{{ $admin->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel-{{ $admin->id }}">Confirm {{ $admin->trashed() ? 'Permanent Deletion' : 'Archival' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to {{ $admin->trashed() ? 'permanently delete' : 'archive' }} admin "{{ $admin->name }}" ({{ $admin->email }})?
                                @if(!$admin->trashed())
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle"></i> Archived admins can be restored later.
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        {{ $admin->trashed() ? 'Permanently Delete' : 'Archive' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 d-flex justify-content-center">
        {{ $admins->appends(request()->query())->links() }}
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        

        // Success/error message handling
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
    });
</script>
@endpush

@endsection
