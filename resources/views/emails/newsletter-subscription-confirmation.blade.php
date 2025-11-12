<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Subscription Confirmed - Al-Maghrib International School</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #FF9800; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
        .info-box { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #FF9800; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Welcome to Our Newsletter!</h1>
            <p>Your subscription has been confirmed</p>
        </div>

        <div class="content">
            <p>Hello!</p>

            <p>Thank you for subscribing to the Al-Maghrib International School newsletter! You're now part of our community and will receive regular updates about:</p>

            <div class="info-box">
                <ul style="margin: 0; padding-left: 20px;">
                    <li>🏫 School news and announcements</li>
                    <li>📅 Upcoming events and activities</li>
                    <li>🎓 Academic achievements and updates</li>
                    <li>👨‍👩‍👧‍👦 Student spotlights and success stories</li>
                    <li>📢 Important notices and deadlines</li>
                    <li>🕌 Islamic events and celebrations</li>
                </ul>
            </div>

            <p><strong>Subscription Details:</strong></p>
            <ul>
                <li><strong>Email:</strong> {{ $subscriber->email }}</li>
                <li><strong>Subscribed:</strong> {{ $subscriber->created_at->format('F j, Y \a\t g:i A') }}</li>
                <li><strong>Frequency:</strong> Bi-weekly (or as needed for important updates)</li>
            </ul>

            <p>You can unsubscribe at any time by clicking the unsubscribe link at the bottom of our emails, or by contacting us directly.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" class="button">Explore Our Website</a>
            </div>

            <p>Al-Maghrib International School is committed to providing quality Islamic and Cambridge curriculum education. By staying connected through our newsletter, you'll be the first to know about opportunities for your child's educational journey.</p>

            <p>If you have any questions or need assistance, please don't hesitate to contact us:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:info@almaghribschool.com">info@almaghribschool.com</a></li>
                <li><strong>Phone:</strong> {{ config('contact.phone_display') }}</li>
                <li><strong>Website:</strong> <a href="{{ route('home') }}">{{ config('app.url') }}</a></li>
            </ul>

            <p>Welcome to the Al-Maghrib family!</p>

            <p>Best regards,<br>
            <strong>Communications Team</strong><br>
            Al-Maghrib International School</p>
        </div>

        <div class="footer">
            <p>This email was sent to {{ $subscriber->email }} because you subscribed to our newsletter.</p>
            <p>© {{ date('Y') }} Al-Maghrib International School. All rights reserved.</p>
        </div>
    </div>
</body>
</html>