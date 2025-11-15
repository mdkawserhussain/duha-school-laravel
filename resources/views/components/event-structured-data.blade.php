@props(['event'])

@php
    $organizationName = \App\Helpers\SiteSettingsHelper::websiteName();
    $eventData = [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $event->title,
        'description' => strip_tags($event->excerpt ?? $event->description),
        'startDate' => $event->event_date->toIso8601String(),
    ];
    
    if ($event->location) {
        $eventData['location'] = [
            '@type' => 'Place',
            'name' => $event->location,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => config('contact.address.city'),
                'addressCountry' => config('contact.address.country'),
            ],
        ];
    }
    
    $eventData['organizer'] = [
        '@type' => 'EducationalOrganization',
        'name' => $organizationName,
        'url' => config('app.url'),
    ];
    
    $eventData['url'] = route('events.show', $event);
@endphp

<script type="application/ld+json">
{!! json_encode($eventData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>