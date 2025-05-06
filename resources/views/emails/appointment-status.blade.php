<!DOCTYPE html>
<html>
<head>
    <title>Appointment Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #223a66;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-top: 20px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            margin: 10px 0;
        }
        .status-confirmed {
            background-color: #10b981;
            color: white;
        }
        .status-canceled {
            background-color: #ef4444;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Appointment Status Update</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $appointment->patient->name }},</p>
        
        <p>Your appointment with Dr. {{ $appointment->doctor->name }} has been <span class="status status-{{ $appointment->status }}">{{ $appointment->status }}</span>.</p>
        
        @if($appointment->status === 'confirmed')
        <p>Appointment Details:</p>
        <ul>
            <li>Date: {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</li>
            <li>Time: {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</li>
            <li>Doctor: Dr. {{ $appointment->doctor->name }}</li>
        </ul>
        @endif
        
        <p>If you have any questions, please don't hesitate to contact us.</p>
        
        <p>Best regards,<br>Heal Point Team <br> +962-797-780-536</p>

    </div>
    
    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
    </div>
</body>
</html> 