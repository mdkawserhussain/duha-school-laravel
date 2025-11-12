@php
$organization = [
    '@context' => 'https://schema.org',
    '@type' => 'EducationalOrganization',
    'name' => config('app.name', 'Al-Maghrib International School'),
    'url' => url('/'),
    'logo' => asset('images/logo.png'),
    'description' => 'Al-Maghrib International School - Providing quality Islamic and Cambridge curriculum education for students from Kindergarten to Grade 12 in Chattogram, Bangladesh',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Chattogram',
        'addressCountry' => 'BD',
    ],
    'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => config('contact.phone', '+880-XXX-XXXXXXX'),
        'contactType' => 'Administrative',
        'email' => config('contact.email', 'info@almaghribschool.com'),
    ],
    'sameAs' => [
        'https://www.facebook.com/almaghribschool',
    ],
];
@endphp

<script type="application/ld+json">
{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

