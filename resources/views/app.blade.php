<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @php $setting = \App\Helpers\SettingsHelper::getSettings(); @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon (Gunakan WebP atau SVG untuk lebih ringan) -->
    <link rel="icon" type="image/svg+xml" href="{{ url('/storage/'.$setting['icon']) }}">

    <!-- Vite untuk Laravel & Vue -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'build')

    <!-- Preload dan Optimasi Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" media="print" onload="this.onload=null;this.media='all';">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"></noscript>

    <!-- Optimasi Material Design Icons -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" media="print" onload="this.onload=null;this.media='all';">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css"></noscript>

    <!-- Inertia.js Head -->
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
