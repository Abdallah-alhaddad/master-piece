@extends('layouts.public.doctorPortal')

@section('styles')
<style>
    .rejection-card {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
        border-top: 4px solid #e12454;
    }
    .rejection-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(239, 68, 68, 0.1);
        border-radius: 50%;
    }
    .rejection-icon svg {
        width: 40px;
        height: 40px;
        color: #ef4444;
    }
    .rejection-title {
        font-size: 1.75rem;
        color: #223a66;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .doctor-name {
        color: #e12454;
        font-weight: 600;
    }
    .rejection-message {
        font-size: 1.1rem;
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    .rejection-reason {
        background-color: rgba(254, 226, 226, 0.5);
        border-left: 4px solid #ef4444;
        padding: 1rem;
        margin: 1.5rem 0;
        text-align: left;
        border-radius: 0 4px 4px 0;
    }
    .rejection-reason-title {
        font-weight: 600;
        color: #dc2626;
        margin-bottom: 0.5rem;
    }
    .action-section {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .btn-primary {
        background-color: #e12454;
        color: white;
    }
    .btn-primary:hover {
        background-color: #c01e48;
    }
    .btn-secondary {
        background-color: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    .btn-secondary:hover {
        background-color: #f1f5f9;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="rejection-card">
        <!-- Rejection Icon -->
        <div class="rejection-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <!-- Title -->
        <h1 class="rejection-title">
            Application Not Approved
        </h1>

        <!-- Personalized Message -->
        <div class="rejection-message">
            <p>Dear <span class="doctor-name">{{ $doctor->name ?? 'Doctor' }}</span>,</p>
            <p>After careful review, we regret to inform you that your application to join our platform has not been approved at this time.</p>
        </div>

        <!-- Rejection Reason -->
        <div class="rejection-reason">
            <div class="rejection-reason-title">Primary Reason:</div>
            <p class="text-sm text-gray-700">
                @if(isset($rejectionReason) && $rejectionReason)
                    {{ $rejectionReason }}
                @else
                    Your application didn't meet our current requirements for practitioner verification.
                @endif
            </p>
        </div>

        <!-- Next Steps -->
        <div class="text-left mb-4">
            <h3 class="font-medium text-gray-800 mb-2">Next Steps:</h3>
            <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                <li>Review the reason for rejection above</li>
                <li>Ensure all submitted documents are valid and current</li>
                <li>You may reapply after addressing the issues</li>
            </ul>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('register.doctor') }}" class="btn-primary px-5 py-2 rounded-md text-sm font-medium text-center">
                    Reapply Now
                </a>
                <a href="mailto:credentials@medicalplatform.com" class="btn-secondary px-5 py-2 rounded-md text-sm font-medium text-center">
                    Contact Credentials Team
                </a>
            </div>
        
        </div>
    </div>
</div>
@endsection
