@php
$siteName = \App\Helpers\SiteHelper::getSiteName();
$siteDescription = \App\Helpers\SiteHelper::getSiteDescription();
$organization = [
    '@context' => 'https://schema.org',
    '@type' => 'EducationalOrganization',
    'name' => $siteName,
    'url' => url('/'),
    'logo' => \App\Models\SiteSettings::getLogoUrl(),
    'description' => $siteName . ' - ' . $siteDescription,
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

