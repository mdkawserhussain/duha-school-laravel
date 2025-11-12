<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Application Received - Al-Maghrib International School</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
        .info-box { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 Admission Application Received</h1>
            <p>Thank you for choosing Al-Maghrib International School</p>
        </div>

        <div class="content">
            <p>Dear {{ $application->parent_name }},</p>

            <p>We have successfully received your admission application for <strong>{{ $application->child_name }}</strong> for Grade {{ $application->grade_applied }}. Thank you for your interest in Al-Maghrib International School.</p>

            <div class="info-box">
                <h3>Application Details:</h3>
                <ul>
                    <li><strong>Parent/Guardian:</strong> {{ $application->parent_name }}</li>
                    <li><strong>Child:</strong> {{ $application->child_name }}</li>
                    <li><strong>Date of Birth:</strong> {{ $application->child_dob->format('F j, Y') }}</li>
                    <li><strong>Grade Applied:</strong> {{ $application->grade_applied }}</li>
                    <li><strong>Application Date:</strong> {{ $application->created_at->format('F j, Y \a\t g:i A') }}</li>
                    <li><strong>Application ID:</strong> #{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</li>
                </ul>
            </div>

            <p><strong>What happens next?</strong></p>
            <ol>
                <li>Our admissions team will review your application within 3-5 business days.</li>
                <li>If additional documents are required, we will contact you via email or phone.</li>
                <li>Shortlisted candidates will be invited for an assessment/interview.</li>
                <li>Final admission decisions will be communicated within 2 weeks of document submission.</li>
            </ol>

            <p>If you have any questions or need to update your application, please contact us:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:info@almaghribschool.com">info@almaghribschool.com</a></li>
                <li><strong>Phone:</strong> {{ config('contact.phone_display') }}</li>
                <li><strong>Office Hours:</strong> Sunday-Thursday, 9:00 AM - 3:00 PM</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" class="button">Visit Our Website</a>
            </div>

            <p>We appreciate your interest in providing quality Islamic and Cambridge curriculum education to your child. Al-Maghrib International School is committed to nurturing young minds in a supportive and values-based environment.</p>

            <p>Best regards,<br>
            <strong>Admissions Team</strong><br>
            Al-Maghrib International School</p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Al-Maghrib International School. All rights reserved.</p>
        </div>
    </div>
</body>
</html>