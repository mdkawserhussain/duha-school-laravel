@php
$siteName = \App\Helpers\SiteSettingsHelper::websiteName();
$siteDescription = \App\Helpers\SiteSettingsHelper::websiteDescription();
$logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
$primaryPhone = \App\Helpers\SiteSettingsHelper::primaryPhone();
$primaryEmail = \App\Helpers\SiteSettingsHelper::primaryEmail();
$physicalAddress = \App\Helpers\SiteSettingsHelper::physicalAddress();
$socialLinks = \App\Helpers\SiteSettingsHelper::socialLinks();

// Parse address for structured data
$addressParts = [];
if ($physicalAddress) {
    // Try to extract locality and country from address
    if (str_contains(strtolower($physicalAddress), 'chittagong') || str_contains(strtolower($physicalAddress), 'chattogram')) {
        $addressParts['addressLocality'] = 'Chattogram';
    }
    if (str_contains(strtolower($physicalAddress), 'bangladesh') || str_contains(strtolower($physicalAddress), 'bd')) {
        $addressParts['addressCountry'] = 'BD';
    }
    $addressParts['streetAddress'] = $physicalAddress;
} else {
    $addressParts['addressLocality'] = 'Chattogram';
    $addressParts['addressCountry'] = 'BD';
}

// Build sameAs array from social links
$sameAs = [];
if (!empty($socialLinks['facebook'])) {
    $sameAs[] = $socialLinks['facebook'];
}
if (!empty($socialLinks['twitter'])) {
    $sameAs[] = $socialLinks['twitter'];
}
if (!empty($socialLinks['instagram'])) {
    $sameAs[] = $socialLinks['instagram'];
}
if (!empty($socialLinks['youtube'])) {
    $sameAs[] = $socialLinks['youtube'];
}
if (!empty($socialLinks['linkedin'])) {
    $sameAs[] = $socialLinks['linkedin'];
}

$organization = [
    '@context' => 'https://schema.org',
    '@type' => 'EducationalOrganization',
    'name' => $siteName,
    'url' => url('/'),
    'logo' => $logoUrl ?? asset('images/logo.svg'),
    'description' => $siteName . ($siteDescription ? ' - ' . $siteDescription : ''),
    'address' => array_merge([
        '@type' => 'PostalAddress',
    ], $addressParts),
    'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => $primaryPhone ?? config('contact.phone', '+880-XXX-XXXXXXX'),
        'contactType' => 'Administrative',
        'email' => $primaryEmail ?? config('contact.email', 'info@duhainternationalschool.com'),
    ],
];

if (!empty($sameAs)) {
    $organization['sameAs'] = $sameAs;
}
@endphp

<script type="application/ld+json">
{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

