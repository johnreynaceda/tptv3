<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application For {{$application->examination->title}}  Status </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #d9534f;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header img {
            max-width: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
        }

        .content {
            padding: 20px;
            text-align: left;
            color: #333;
        }

        .content p {
            margin: 10px 0;
            line-height: 1.8;
            font-size: 16px;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        .footer a {
            color: #d9534f;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ url('images/sksu1.png') }}" alt="SKSU Logo">
            <h1>🚫 Application Rejected</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi {{ $application->user->personal_information->fullName() }},</p>
            <p>
                We regret to inform you that your application for the <strong>{{$application->examination->title}}</strong> has been rejected.
            </p>
            <p>
                <strong>Reason:</strong> {{ $remarks }}
            </p>
            <p>
                If you believe this decision was made in error or if you wish to resubmit your application, please contact our support team for further instructions.
            </p>
            <p>
                Thank you for your understanding.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>📩 Need assistance? Contact us at <a href="mailto:sksu-support@example.com">sksu-support@example.com</a></p>
            <p>&copy; {{ date('Y') }} Sultan Kudarat State University</p>
        </div>
    </div>
</body>
</html>
