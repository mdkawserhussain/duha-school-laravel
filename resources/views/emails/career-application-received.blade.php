<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Application Received - {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
        .info-box { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #4CAF50; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💼 Career Application Received</h1>
            <p>Thank you for your interest in joining our team</p>
        </div>

        <div class="content">
            <p>Dear {{ $application->applicant_name }},</p>

            <p>We have successfully received your application for the <strong>{{ $application->job_title }}</strong> position at {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}. Thank you for your interest in joining our dedicated team of educators and professionals.</p>

            <div class="info-box">
                <h3>Application Details:</h3>
                <ul>
                    <li><strong>Position Applied:</strong> {{ $application->job_title }}</li>
                    <li><strong>Applicant Name:</strong> {{ $application->applicant_name }}</li>
                    <li><strong>Email:</strong> {{ $application->email }}</li>
                    @if($application->phone)
                    <li><strong>Phone:</strong> {{ $application->phone }}</li>
                    @endif
                    <li><strong>Application Date:</strong> {{ $application->created_at->format('F j, Y \a\t g:i A') }}</li>
                    <li><strong>Application ID:</strong> #{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</li>
                </ul>
            </div>

            <p><strong>What happens next?</strong></p>
            <ol>
                <li>Our HR team will review your application within 5-7 business days.</li>
                <li>Shortlisted candidates will be contacted for interviews or assessments.</li>
                <li>The entire recruitment process typically takes 2-4 weeks.</li>
                <li>All candidates will be notified of the final outcome.</li>
            </ol>

            <p>If you have any questions about your application or need to update your information, please contact our HR department:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:career@almaghribschool.com">career@almaghribschool.com</a></li>
                <li><strong>Phone:</strong> {{ config('contact.phone_display') }}</li>
                <li><strong>Office Hours:</strong> Sunday-Thursday, 9:00 AM - 3:00 PM</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('careers.index') }}" class="button">View Other Opportunities</a>
            </div>

            <p>We appreciate your interest in contributing to the mission of {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}. Our institution is committed to providing quality education in a supportive Islamic environment, and we value team members who share this vision.</p>

            <p>Best regards,<br>
            <strong>Human Resources Team</strong><br>
            {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}</p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>