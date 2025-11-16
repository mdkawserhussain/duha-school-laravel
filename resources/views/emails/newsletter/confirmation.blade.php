<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Newsletter Subscription</title>
</head>
<body>
    <p>Assalamu Alaikum {{ $subscriber->name ?? 'there' }},</p>
    <p>Thanks for subscribing to the {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }} newsletter. We will keep you updated with events, achievements, and important announcements.</p>
    <p>If you received this email in error, please ignore it.</p>
    <p>JazakAllahu Khairan,<br>{{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}</p>
</body>
</html>
