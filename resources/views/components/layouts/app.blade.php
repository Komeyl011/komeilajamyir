<!DOCTYPE html>
<html {!! app()->getLocale() === 'fa' ? 'lang="fa"' . ' dir="rtl"' : 'lang="en"' . ' dir="ltr"' !!}>
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-59T4D5FQKZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-59T4D5FQKZ');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komeil Ajamy - Personal Website</title>
    <meta name="description" content="Komeil Ajamy's personal resume website.">
    <meta name="keywords" content="Komeil Ajamy, کمیل عجمی, Komeil, Ajamy, PHP Developer, برنامه‌نویس PHP">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Komeil Ajamy',
            'url' => config('app.url'),
            'image' => Storage::disk('liara')->url('about-me/September2024/adUTGW5NCb4hPKBdPHxs7u4w04ZhR1aIcvHbDbJ2.jpg'),
            'sameAs' => 'https://github.com/Komeyl011',
            'jobTitle' => 'Software Developer',
            'description' => 'Experienced software developer specializing in Laravel and PHP.',
          ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 {{ app()->currentLocale() == 'fa' ? 'vazir-regular' : 'roboto-regular' }}">

<!-- Hero Section -->
@include('components.layouts.partials.header')

<!-- Main Content -->
{{ $slot }}

<!-- Footer -->
@include('components.layouts.partials.footer')

<script src="{{ Storage::disk('liara')->url('js/script.js') }}"></script>
<script src="https://kit.fontawesome.com/57a53d4203.js" crossorigin="anonymous"></script>
</body>
</html>
