@extends('layouts.public.doctorPortal')

@section('styles')
<style>
    :root {
        --primary-color: #e12454;
        --primary-hover: #c01e48;
        --secondary-color: #6c757d;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* Base Styles */
    body {
        background-color: #f5f7fa;
    }

    .container {
        max-width: 1200px;
    }

    /* Card Styles */
    .profile-card {
        border: none;
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow: hidden;
        background-color: #fff;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
    }

    .card-header h4 {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .card-body {
        padding: 2rem;
    }

    /* Tab Styles */
    .nav-tabs {
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        color: var(--secondary-color);
        font-weight: 500;
        border: none;
        padding: 0.75rem 1.5rem;
        position: relative;
        transition: var(--transition);
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background: transparent;
        border: none;
    }

    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 3px 3px 0 0;
    }

    /* Form Styles */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(225, 36, 84, 0.15);
    }

    .error-message {
        color: var(--primary-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Button Styles */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    /* Days Selection */
    .days-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .day-checkbox {
        display: none;
    }

    .day-label {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.875rem;
        user-select: none;
    }

    .day-checkbox:checked + .day-label {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* File Upload */
    .file-upload {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: var(--light-gray);
    }

    .file-upload:hover {
        border-color: var(--primary-color);
        background-color: rgba(225, 36, 84, 0.05);
    }

    .file-upload i {
        font-size: 2rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .preview-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-top: 1rem;
    }

    /* Section Styling */
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 3px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tab-pane {
        animation: fadeIn 0.3s ease-out;
    }

    /* Modern Input Group */
    .input-group-text {
        background-color: var(--light-gray);
        border: 1px solid var(--border-color);
    }

    /* Time Input Styling */
    .time-input-group {
        display: flex;
        align-items: center;
    }

    .time-input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    .time-input-group .input-group-text {
        border-radius: 0 8px 8px 0;
        border-left: none;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="profile-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Edit Doctor Profile</h4>
                        <div>
                            <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" id="doctorTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                                <i class="fas fa-user-circle me-2"></i>Profile
                            </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                <i class="fas fa-lock me-2"></i>Password
                            </button>
                        </li> --}}
                    </ul>

                    <div class="tab-content py-3" id="doctorTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <form method="POST" action="{{ route('doctors.updateDoctor', $doctor->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <h5 class="section-title">Personal Information</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Full Name *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $doctor->name) }}" required>
                                            </div>
                                            @error('name')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $doctor->email) }}" required>
                                            </div>
                                            @error('email')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}">
                                            </div>
                                            @error('phone')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specialization_id" class="form-label">Specialization *</label>
                                            <select class="form-select @error('specialization_id') is-invalid @enderror" id="specialization_id" name="specialization_id" required>
                                                <option value="">Select Specialization</option>
                                                @foreach($specializations as $specialization)
                                                    <option value="{{ $specialization->id }}" {{ old('specialization_id', $doctor->specialization_id) == $specialization->id ? 'selected' : '' }}>
                                                        {{ $specialization->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('specialization_id')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h5 class="section-title mt-5">Professional Details</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="experience_years" class="form-label">Experience (Years)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" id="experience_years" name="experience_years" value="{{ old('experience_years', $doctor->experience_years) }}">
                                            </div>
                                            @error('experience_years')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price_per_appointment" class="form-label">Price Per Appointment (JOD)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">JOD</span>
                                                <input type="number" step="0.01" class="form-control @error('price_per_appointment') is-invalid @enderror" id="price_per_appointment" name="price_per_appointment" value="{{ old('price_per_appointment', $doctor->price_per_appointment) }}">
                                            </div>
                                            @error('price_per_appointment')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="bio" class="form-label">Professional Bio</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $doctor->bio) }}</textarea>
                                            @error('bio')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h5 class="section-title mt-5">Clinic Information</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="governorate" class="form-label">Governorate</label>
                                            <select class="form-select @error('governorate') is-invalid @enderror" id="governorate" name="governorate">
                                                <option value="">Select Governorate</option>
                                                @foreach(['Amman', 'Irbid', 'Ajloun', 'Aqaba', 'Balqa', 'Zarqa', 'Mafraq', 'Maan', 'Tafilah', 'Karak', 'Jerash'] as $gov)
                                                    <option value="{{ $gov }}" {{ old('governorate', $doctor->governorate) == $gov ? 'selected' : '' }}>{{ $gov }}</option>
                                                @endforeach
                                            </select>
                                            @error('governorate')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Clinic Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $doctor->address) }}">
                                            </div>
                                            @error('address')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h5 class="section-title mt-5">Availability</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Available Days</label>
                                            <div class="days-container">
                                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                                    <input type="checkbox" id="{{ $day }}" name="{{ $day }}" value="1" class="day-checkbox" {{ old($day, $doctor->$day) ? 'checked' : '' }}>
                                                    <label for="{{ $day }}" class="day-label">{{ ucfirst($day) }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="working_hours_start" class="form-label">Working Hours Start</label>
                                                    <div class="time-input-group">
                                                        <input type="time" class="form-control @error('working_hours_start') is-invalid @enderror" id="working_hours_start" name="working_hours_start" value="{{ old('working_hours_start', $doctor->working_hours_start ? \Carbon\Carbon::parse($doctor->working_hours_start)->format('H:i') : '09:00') }}">
                                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    </div>
                                                    @error('working_hours_start')
                                                        <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="working_hours_end" class="form-label">Working Hours End</label>
                                                    <div class="time-input-group">
                                                        <input type="time" class="form-control @error('working_hours_end') is-invalid @enderror" id="working_hours_end" name="working_hours_end" value="{{ old('working_hours_end', $doctor->working_hours_end ? \Carbon\Carbon::parse($doctor->working_hours_end)->format('H:i') : '17:00') }}">
                                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    </div>
                                                    @error('working_hours_end')
                                                        <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="section-title mt-5">Documents</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Profile Image</label>
                                            <div class="file-upload" onclick="document.getElementById('image').click()">
                                                <input type="file" class="d-none" id="image" name="image" accept="image/*">
                                                <div class="text-center">
                                                    <i class="fas fa-camera"></i>
                                                    <p class="mb-0">Click to upload image</p>
                                                    <small class="text-muted">JPEG, PNG (Max 2MB)</small>
                                                </div>
                                            </div>
                                            @if($doctor->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $doctor->image) }}" class="preview-image" id="image-preview">
                                                </div>
                                            @endif
                                            @error('image')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="doctor_document" class="form-label">Medical License</label>
                                            <div class="file-upload" onclick="document.getElementById('doctor_document').click()">
                                                <input type="file" class="d-none" id="doctor_document" name="doctor_document" accept=".pdf">
                                                <div class="text-center">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <p class="mb-0">Click to upload document</p>
                                                    <small class="text-muted">PDF only (Max 5MB)</small>
                                                </div>
                                            </div>
                                            @if($doctor->doctor_document)
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $doctor->doctor_document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-2"></i>View Current Document
                                                    </a>
                                                </div>
                                            @endif
                                            @error('doctor_document')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Password Tab - NOW WORKING -->
                        {{-- <div class="tab-pane fade" id="password" role="tabpanel">
                            <form method="POST" action="{{ route('doctors.updatePassword', $doctor->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="form-group mb-4">
                                            <label for="current_password" class="form-label">Current Password *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('current_password')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="new_password" class="form-label">New Password *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('new_password')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="new_password_confirmation" class="form-label">Confirm New Password *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-sync-alt me-2"></i>Update Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tabs
        var tabElms = [].slice.call(document.querySelectorAll('button[data-bs-toggle="tab"]'));
        tabElms.forEach(function(tabEl) {
            tabEl.addEventListener('click', function(event) {
                event.preventDefault();
                var tab = new bootstrap.Tab(tabEl);
                tab.show();
            });
        });

        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var preview = document.getElementById('image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = 'image-preview';
                        preview.className = 'preview-image mt-2';
                        document.querySelector('#image').closest('.form-group').appendChild(preview);
                    }
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Form validation for password match
        const passwordForm = document.querySelector('form[action*="updatePassword"]');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                var newPassword = document.getElementById('new_password').value;
                var confirmPassword = document.getElementById('new_password_confirmation').value;

                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    // Show error message in a modern way
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-3';
                    errorDiv.textContent = 'Passwords do not match!';

                    const existingError = passwordForm.querySelector('.alert-danger');
                    if (existingError) {
                        existingError.remove();
                    }

                    passwordForm.insertBefore(errorDiv, passwordForm.lastElementChild);

                    // Scroll to error
                    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }
    });
</script>
@endsection
