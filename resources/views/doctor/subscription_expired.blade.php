@extends('layouts.public.doctorPortal')
@section('styles')
<style>
    .subscription-container {
        max-width: 1000px;
        margin: 2rem auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border-top: 4px solid #e12454;
        overflow: hidden;
        position: relative;
    }
    .card-step {
        padding: 2.5rem;
        display: none; /* Initially hidden */
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .card-step.active {
        display: block; /* Show active step */
    }
    .subscription-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
    }
    .subscription-plans {
        display: flex;
        justify-content: space-around;
        align-items: stretch;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    .plan-card {
        flex: 1;
        min-width: 250px;
        max-width: 300px;
        background-color: #f8fafc;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        padding: 0 0 1.5rem 0;
        text-align: center;
        cursor: pointer;
        border: 2px solid transparent;
    }
    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        border-color: #e12454;
    }
    .plan-card.selected {
        border-color: #e12454;
        background-color: #fff5f7;
    }
    .plan-header {
        background-color: #e12454;
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 10px 10px 0 0;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .plan-title {
        font-size: 1.5rem;
        color: #223a66;
        margin: 1rem 0;
        font-weight: 700;
    }
    .plan-price {
        font-size: 2rem;
        color: #e12454;
        margin: 1rem 0;
        font-weight: 700;
    }
    .plan-discount {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.5rem;
        font-style: italic;
    }
    .plan-features {
        padding: 0 1rem;
        margin: 1.5rem 0;
        text-align: left;
    }
    .plan-feature {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    .plan-feature:before {
        content: "✓";
        color: #e12454;
        margin-right: 0.5rem;
        font-weight: bold;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #223a66;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    .form-input:focus {
        outline: none;
        border-color: #e12454;
        box-shadow: 0 0 0 3px rgba(225, 36, 84, 0.1);
    }
    .btn-subscribe {
        background-color: #e12454;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        width: 100%;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
        margin-top: 1rem;
    }
    .btn-subscribe:hover {
        background-color: #c01e48;
        transform: translateY(-2px);
    }
    .btn-subscribe:disabled {
        background-color: #cbd5e0;
        cursor: not-allowed;
        transform: none;
    }
    .total-display {
        background-color: #f8fafc;
        padding: 1.5rem;
        border-radius: 6px;
        margin: 2rem 0 1rem;
        text-align: center;
        border: 1px dashed #e12454;
    }
    .total-label {
        font-weight: 600;
        color: #64748b;
        font-size: 1rem;
    }
    .total-amount {
        font-size: 1.75rem;
        font-weight: 700;
        color: #223a66;
        margin-top: 0.5rem;
    }
    .back-button {
        background-color: transparent;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .back-button:hover {
        background-color: #f8fafc;
        color: #e12454;
        border-color: #e12454;
    }
    .back-button svg {
        margin-right: 0.5rem;
    }
    .pricing-header {
        margin-top: 20px;
        text-align: center;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 2rem;
    }
    .pricing-title {
        font-size: 1.8rem;
        color: #223a66;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }
    .pricing-subtitle {
        color: #64748b;
        font-size: 1rem;
    }
    .payment-methods {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin: 1rem 0 2rem;
    }
    .payment-method {
        width: 50px;
        opacity: 0.7;
        transition: opacity 0.3s;
    }
    .payment-method:hover {
        opacity: 1;
    }
    @media (max-width: 768px) {
        .subscription-plans {
            flex-direction: column;
            align-items: center;
        }
        .plan-card {
            width: 100%;
        }
        .card-step {
            padding: 1.5rem;
        }
    }
    /* Container Styling */
.payment-methods {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    gap: 16px; /* Space between icons */
    padding: 16px;
    margin: auto
    background-color: #f9f9f9; /* Light background for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: fit-content;
}

/* Individual Icon Styling */
.payment-method {
    width: 50px; /* Fixed size for consistency */
    height: auto; /* Maintain aspect ratio */
    transition: transform 0.3s ease, opacity 0.3s ease; /* Smooth transitions */
    cursor: pointer; /* Pointer cursor for interactivity */
}

/* Hover Effects */
.payment-method:hover {
    transform: scale(1.1); /* Slightly enlarge on hover */
    opacity: 0.8; /* Reduce opacity for visual feedback */
}

/* Responsive Design */
@media (max-width: 600px) {
    .payment-methods {
        flex-direction: column; /* Stack icons vertically on small screens */
        gap: 8px; /* Reduce spacing */
    }
    .payment-method {
        width: 40px; /* Smaller icons for mobile */
    }
}
</style>

@endsection
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="subscription-container">
        <!-- Step 1: Subscription Plans -->
        <div class="card-step active" id="step-1">
            <div class="pricing-header">
                <h1 class="pricing-title">Choose Your Plan</h1>
                <p class="pricing-subtitle">Select the plan that best fits your practice needs</p>
            </div>
            <div class="subscription-plans">
                <!-- Plan 1: 1 Month -->
                <div class="plan-card" onclick="selectPlan(1, 50, this)">
                    <div class="plan-header">Monthly</div>
                    <h2 class="plan-title">1 Month</h2>
                    <p class="plan-price">50 JOD</p>
                    <div class="plan-features">
                        <div class="plan-feature">Full platform access</div>
                        <div class="plan-feature">Patient management</div>
                        <div class="plan-feature">Appointment scheduling</div>
                        <div class="plan-feature">24/7 support</div>
                    </div>
                </div>

                <!-- Plan 2: 1 Year -->
                <div class="plan-card" onclick="selectPlan(12, 300, this)">
                    <div class="plan-header">Annual</div>
                    <h2 class="plan-title">1 Year</h2>
                    <p class="plan-price">300 JOD</p>
                    <p class="plan-discount">Save 50% (25 JOD/month)</p>
                    <div class="plan-features">
                        <div class="plan-feature">Everything in Monthly</div>
                        <div class="plan-feature">Priority support</div>
                        <div class="plan-feature">Yearly analytics report</div>
                        <div class="plan-feature">2 free months</div>
                    </div>
                </div>

                <!-- Plan 3: Lifetime -->
                <div class="plan-card" onclick="selectPlan('lifetime', 600, this)">
                    <div class="plan-header">Lifetime</div>
                    <h2 class="plan-title">Lifetime</h2>
                    <p class="plan-price">600 JOD</p>
                    <div class="plan-features">
                        <div class="plan-feature">Everything in Annual</div>
                        <div class="plan-feature">One-time payment</div>
                        <div class="plan-feature">Future updates included</div>
                        <div class="plan-feature">VIP support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Payment Information -->
        <div class="card-step" id="step-2">
            <button class="back-button" onclick="goBackToPlans()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Back to Plans
            </button>

            <div class="pricing-header">
                <h1 class="pricing-title">Payment Information</h1>
                <p class="pricing-subtitle">Enter your details to complete subscription</p>
            </div>

            <div class="payment-methods">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png"
                     class="payment-method" alt="Visa" onerror="this.src='fallback-visa.png';">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                     class="payment-method" alt="Mastercard" onerror="this.src='fallback-mastercard.png';">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg"
                     class="payment-method" alt="Apple Pay" onerror="this.src='fallback-applepay.png';">
            </div>

            <form id="subscription-form" action="{{ route('doctor.subscription.process') }}" method="POST">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <input type="hidden" name="duration_months" id="duration_months" value="">
                <input type="hidden" name="amount" id="amount" value="">

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-input" name="full_name" placeholder="Your full name" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" name="email" value="{{ $doctor->email }}" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Card Number</label>
                    <input type="text" class="form-input" name="card_number" placeholder="1234 5678 9012 3456" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Expiry Date</label>
                        <input type="text" class="form-input" name="expiry_date" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-input" name="cvv" placeholder="123" required>
                    </div>
                </div>

                <div class="total-display" id="total-section">
                    <div class="total-label">Total Amount</div>
                    <div class="total-amount" id="total-amount">0 JOD</div>
                </div>

                <button type="submit" class="btn-subscribe" id="submit-button">
                    Complete Subscription
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    let selectedPlanCard = null;

    function selectPlan(months, amount, element) {
        // Remove selected class from all cards
        document.querySelectorAll('.plan-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to clicked card
        element.classList.add('selected');
        selectedPlanCard = element;

        // Update form fields
        document.getElementById('duration_months').value = months;
        document.getElementById('amount').value = amount;

        // Update total display
        document.getElementById('total-amount').textContent = amount + ' JOD';

        // Switch to the payment info card
        document.getElementById('step-1').classList.remove('active');
        document.getElementById('step-2').classList.add('active');

        // Scroll to top of the container
        document.querySelector('.subscription-container').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function goBackToPlans() {
        // Switch back to plans card
        document.getElementById('step-2').classList.remove('active');
        document.getElementById('step-1').classList.add('active');

        // Scroll to top of the container
        document.querySelector('.subscription-container').scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>
@endsection
