<!DOCTYPE html>
<html>
<head>
    <title>Doctor Status Update</title>
    <link rel="stylesheet" href="{{ asset('assets/css/doctor-status-email.css') }}">
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Heal Point Logo" class="logo">
    </div>

    <h2>Dear Dr. {{ $doctor->name }},</h2>

    @if($status === 'approved')
        <div class="status approved">
            Congratulations! Your application has been approved.
        </div>

        <p>We are pleased to inform you that your application to join Heal Point has been approved. You can now access your dashboard and start managing your profile.</p>

        <div class="steps">
            <h3>Next Steps:</h3>
            <div class="step">Log in to your dashboard using your email and password</div>
            <div class="step">Complete your profile information</div>
            <div class="step">Upload your professional documents and certificates</div>
            <div class="step">Set up your availability schedule</div>
            <div class="step">Configure your consultation fees</div>
        </div>

        <h3>Subscription Process:</h3>
        <p>To activate your account and start receiving patients, you need to complete the subscription process:</p>
        <ol>
            <li>Log in to your dashboard</li>
            <li>Go to the Subscription section</li>
            <li>Choose your preferred subscription plan</li>
            <li>Complete the payment process</li>
            <li>Your account will be activated immediately after payment confirmation</li>
        </ol>

        <p>If you have any questions about the subscription process or need assistance, please don't hesitate to contact our support team.</p>

    @else
        <div class="status rejected">
            Application Status: Rejected
        </div>

        <p>We regret to inform you that your application to join Heal Point has been rejected at this time.</p>

        <div class="contact-info">
            <h3>Need Help?</h3>
            <p>If you would like to discuss the reasons for rejection or need assistance with your application, please contact our support team:</p>
            <p><strong>Phone:</strong> +962-797-780-536</p>
            <p><strong>Email:</strong> support@healpoint.com</p>
            <p><strong>Working Hours:</strong> Sunday - Thursday, 9:00 AM - 5:00 PM</p>
        </div>

        <p>We encourage you to review your application and documentation. You may reapply after addressing any issues or providing additional required information.</p>
    @endif

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Heal Point. All rights reserved.</p>
    </div>
</body>
</html> 