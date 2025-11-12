<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message Received - Al-Maghrib International School</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #2196F3; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
        .message-box { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #2196F3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 Contact Message Received</h1>
            <p>Thank you for reaching out to us</p>
        </div>

        <div class="content">
            <p>Dear {{ $data['name'] }},</p>

            <p>Thank you for contacting Al-Maghrib International School. We have received your message and appreciate you taking the time to reach out to us.</p>

            <div class="message-box">
                <h3>Your Message Details:</h3>
                <ul>
                    <li><strong>Subject:</strong> {{ $data['subject'] }}</li>
                    <li><strong>Name:</strong> {{ $data['name'] }}</li>
                    <li><strong>Email:</strong> {{ $data['email'] }}</li>
                    @if(isset($data['phone']) && $data['phone'])
                    <li><strong>Phone:</strong> {{ $data['phone'] }}</li>
                    @endif
                    <li><strong>Received:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</li>
                </ul>

                <h4 style="margin-top: 15px;">Your Message:</h4>
                <div style="background: #f5f5f5; padding: 15px; border-radius: 3px; margin-top: 10px;">
                    {!! nl2br(e($data['message'])) !!}
                </div>
            </div>

            <p><strong>What happens next?</strong></p>
            <ul>
                <li>Our team will review your message and respond within 24 hours during business days.</li>
                <li>For urgent matters, please call us directly at {{ config('contact.phone_display') }}.</li>
                <li>Response times may be longer during weekends and holidays.</li>
            </ul>

            <p>If this is regarding admissions, please visit our <a href="{{ route('admission.index') }}">admissions page</a> for more information. For career opportunities, check our <a href="{{ route('careers.index') }}">careers page</a>.</p>

            <p>You can also reach us through:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:info@almaghribschool.com">info@almaghribschool.com</a></li>
                <li><strong>Phone:</strong> {{ config('contact.phone_display') }}</li>
                <li><strong>Office Hours:</strong> Sunday-Thursday, 9:00 AM - 3:00 PM</li>
                <li><strong>Address:</strong> Al-Maghrib International School, Chattogram, Bangladesh</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" class="button">Visit Our Website</a>
            </div>

            <p>Thank you for your interest in Al-Maghrib International School. We look forward to assisting you.</p>

            <p>Best regards,<br>
            <strong>Communications Team</strong><br>
            Al-Maghrib International School</p>
        </div>

        <div class="footer">
            <p>This is an automated confirmation. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Al-Maghrib International School. All rights reserved.</p>
        </div>
    </div>
</body>
</html>