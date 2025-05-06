@extends('layouts.public.doctorPortal')

@section('styles')
<style>
    .approval-card {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
        border-top: 4px solid #e12454;
    }
    .approval-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(225, 36, 84, 0.1);
        border-radius: 50%;
    }
    .approval-icon svg {
        width: 40px;
        height: 40px;
        color: #e12454;
    }
    .approval-title {
        font-size: 1.75rem;
        color: #223a66;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .doctor-name {
        color: #e12454;
        font-weight: 600;
    }
    .approval-message {
        font-size: 1.1rem;
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    .timeline-notice {
        background-color: rgba(251, 191, 36, 0.1);
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        margin: 1.5rem 0;
        text-align: left;
        border-radius: 0 4px 4px 0;
    }
    .support-section {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .btn-logout {
        background-color: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        margin-top: 1.5rem;
    }
    .btn-logout:hover {
        background-color: #f1f5f9;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="approval-card">
        <!-- Approval Icon -->
        <div class="approval-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Title -->
        <h1 class="approval-title">
            Registration Under Review
        </h1>

        <!-- Personalized Message -->
        <div class="approval-message">
            <p>Dear <span class="doctor-name">{{ $doctor->name ?? 'Doctor' }}</span>,</p>
            <p>We've received your application to join our medical platform and it's currently being reviewed by our team.</p>
            <p>This process typically takes <strong>1-2 business days</strong>. We'll notify you via email once your account is approved.</p>
        </div>

        <!-- Timeline Notice -->
        <div class="timeline-notice">
            <div class="flex items-start">
                <svg class="h-5 w-5 text-amber-500 mt-0.5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-sm text-gray-700">
                        <strong>Note:</strong> During peak times, verification may take slightly longer. We appreciate your patience.
                    </p>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="support-section">
            <h3 class="text-md font-medium text-gray-700 mb-2">Have questions about your application?</h3>
            <p class="text-sm text-gray-600 mb-3">Our support team is happy to help:</p>
            <div class="flex justify-center space-x-4">
                <a href="mailto:support@medicalplatform.com" class="text-sm text-[#e12454] hover:text-[#c01e48] font-medium flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email Support
                </a>
                <a href="tel:+96260000000" class="text-sm text-[#223a66] hover:text-[#1a2d52] font-medium flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Call Support
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
