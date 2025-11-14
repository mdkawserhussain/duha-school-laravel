@props(['event'])

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "{{ $event->title }}",
    "description": "{{ strip_tags($event->excerpt ?? $event->description) }}",
    "startDate": "{{ $event->event_date->toIso8601String() }}",
    @if($event->location)
    "location": {
        "@type": "Place",
        "name": "{{ $event->location }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "{{ config('contact.address.city') }}",
            "addressCountry": "{{ config('contact.address.country') }}"
        }
    },
    @endif
    "organizer": {
        "@type": "EducationalOrganization",
        "name": "{{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}",
        "url": "{{ config('app.url') }}"
    },
    "url": "{{ route('events.show', $event) }}"
}
</script>

