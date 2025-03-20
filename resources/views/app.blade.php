<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @php $setting = \App\Helpers\SettingsHelper::getSettings(); @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting['title'] ?? 'Website' }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('/storage/' . $setting['icon']) }}" type="image/png">

    <!-- Google Fonts (Optimasi: Preload + Display Swap) -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" as="style" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" crossorigin="anonymous">

    <!-- Material Design Icons (Gunakan CDN untuk kecepatan) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

    <!-- Vite Assets (Gunakan Defer untuk Menghindari Render Blocking) -->
    @vite(['resources/css/app.css'], 'defer')
    @vite(['resources/js/app.js'], 'defer')

    <!-- CSS Tambahan (Font Poppins dioptimasi) -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .poppins {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
        }
        .poppins-bold {
            font-weight: 700;
        }
        .poppins-light {
            font-weight: 300;
        }
    </style>

    @inertiaHead
</head>

<body>
    <!-- Kontainer utama Inertia -->
    @inertia

    <!-- Optimasi: Gunakan defer untuk menghindari blocking -->
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}" defer></script>
</body>
</html>
