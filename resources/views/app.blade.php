<!DOCTYPE html>
<html class="scroll-smooth">
<head>
    @php $setting = \App\Helpers\SettingsHelper::getSettings(); @endphp
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
   <link rel="shortcut icon" href="{{url('/storage/'.$setting['icon'])}}"/>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&display=swap&ver=6.7.2"
        rel="stylesheet">
    <style type="text/css">
    .poppins-black,.poppins-bold,.poppins-extrabold,.poppins-extralight,.poppins-light,.poppins-medium,.poppins-regular,.poppins-semibold,.poppins-thin{font-family:Poppins,sans-serif;font-style:normal}.poppins-thin{font-weight:100}.poppins-extralight{font-weight:200}.poppins-light{font-weight:300}.poppins-regular{font-weight:400}.poppins-medium{font-weight:500}.poppins-semibold{font-weight:600}.poppins-bold{font-weight:700}.poppins-extrabold{font-weight:800}.poppins-black{font-weight:900}.poppins-black-italic,.poppins-bold-italic,.poppins-extrabold-italic,.poppins-extralight-italic,.poppins-light-italic,.poppins-medium-italic,.poppins-regular-italic,.poppins-semibold-italic,.poppins-thin-italic{font-family:Poppins,sans-serif;font-style:italic}.poppins-thin-italic{font-weight:100}.poppins-extralight-italic{font-weight:200}.poppins-light-italic{font-weight:300}.poppins-regular-italic{font-weight:400}.poppins-medium-italic{font-weight:500}.poppins-semibold-italic{font-weight:600}.poppins-bold-italic{font-weight:700}.poppins-extrabold-italic{font-weight:800}.poppins-black-italic{font-weight:900}
    </style>
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
