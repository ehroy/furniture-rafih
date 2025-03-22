<!DOCTYPE html>
<html lang="id">
<head>
    @php $setting = \App\Helpers\SettingsHelper::getSettings(); @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <!-- Favicon dari Storage -->
    <link rel="shortcut icon" href="{{ url('/storage/' . $setting['icon']) }}" type="image/png">

    <!-- Load Tailwind & Custom CSS -->
    @vite(['resources/css/app.css'])

    <!-- Material Design Icons (Subset) -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css"></noscript>

    <!-- Optimized Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@100;300;400;500;600;700;900&display=swap">

    <!-- Lazy Load JavaScript -->
    <script type="module" src="{{ vite_asset('resources/js/app.js') }}" defer></script>

    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
