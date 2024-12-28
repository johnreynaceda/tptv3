<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Validation For {{$permit->examination->title}} Status</title>
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
            background-color: #106c3b;
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

        .cta-button {
            margin: 20px 0;
            display: inline-block;
            padding: 12px 25px;
            background-color: #106c3b;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        .cta-button:hover {
            background-color: #0e5a31;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        .footer a {
            color: #106c3b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ url('images/sksu1.png') }}" alt="SKSU Logo">
            <h1>🎉 Payment Validation Completed! 🎉</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi {{ $permit->user->personal_information->fullName() }},</p>
            <p>
                Thank you for submitting your proof of payment for the <strong>{{$permit->examination->title}}</strong>. We are pleased to inform you that your payment has been validated successfully.
            </p>
            <p>
                You are now eligible to proceed with the entrance examination process. Please note the following key steps ahead:
            </p>
            <ol>
                <li><strong>Book Your Exam Slot:</strong> You can now select an available exam date, time, and location through your account portal.</li>
                <li><strong>Exam Permit:</strong> Once you have booked your slot, you can access and download your official exam permit from your account portal.</li>
                <li><strong>Preparation:</strong> Ensure you review the instructions and bring all required materials on the exam day.</li>
            </ol>
            
            <p>
                <strong>Note:</strong> Validation of payment and completion of the entrance test are preliminary steps. Final admission to the university is subject to further evaluations and processes.
            </p>
            <p>
                If you have any questions or require assistance, feel free to reach out to us.
            </p>
            
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>📩 Need assistance? Contact us at <a href="mailto:sksu-support@example.com">sksutpt@gmail.com</a></p>
            <p>&copy; {{ date('Y') }} Sultan Kudarat State University</p>
        </div>
    </div>
</body>
</html>
