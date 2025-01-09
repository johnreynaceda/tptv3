<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrance Exam Slot Selection</title>
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
            font-size: 24px;
            line-height: 1.5;
        }

        .content {
            padding: 20px;
            text-align: left;
            color: #333;
        }

        .content p {
            margin: 10px 0;
            line-height: 1.6;
            font-size: 16px;
        }

        .content ol {
            margin: 15px 0;
            padding-left: 20px;
        }

        .content ol li {
            margin: 10px 0;
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
            text-align: center;
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
                Thank you for submitting your proof of payment for the <strong>{{ $permit->examination->title }}</strong>. We are pleased to inform you that your payment has been successfully validated!
            </p>
            <p>
                To proceed with the entrance examination, you need to log in again and complete the next step by selecting your exam schedule.
            </p>
            <ol>
                <li><strong>Step 1: Log in to Your Account</strong>
                    Visit our portal at <a href="https://sksu-tpt.com" target="_blank">https://sksu-tpt.com</a> and log in using your registered Gmail account.
                </li>
                <li><strong>Step 2: Select Your Slot</strong>
                    After logging in, navigate to the "Selection of Test Center" page. From there, you will be able to:
                    <ul>
                        <li>Choose your preferred exam time.</li>
                        <li>Select the exam date that suits you.</li>
                        <li>Pick the most convenient test center.</li>
                    </ul>
                </li>
                <li><strong>Step 3: Download Your Exam Permit</strong>
                    Once you have selected your slot, you will be able to download your official exam permit.
                </li>
            </ol>

            <p>
                <strong>Note:</strong> Selecting your slot is essential to finalize your entrance examination schedule. Please complete this step as soon as possible.
            </p>
            <p>
                If you have any questions or require assistance, don’t hesitate to contact us at <a href="mailto:sksutpt@gmail.com">sksutpt@gmail.com</a>.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>📩 Need help? Email us at <a href="mailto:sksutpt@gmail.com">sksutpt@gmail.com</a></p>
            <p>&copy; {{ date('Y') }} Sultan Kudarat State University. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
