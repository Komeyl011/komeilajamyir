<!DOCTYPE html>
<html lang="{{ app()->currentLocale() }}" dir="{{ app()->currentLocale() == 'fa' ? 'rtl' : 'ltr' }}">
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
    <title>@yield('title', app()->currentLocale() == 'fa' ? 'بلاگ کمیل عجمی - صفحه اصلی' : 'Komeil Ajamy Blog - Main page') - {{ app()->currentLocale() == 'fa' ? 'کمیل عجمی' : 'Komeil Ajamy' }}</title>
    @yield('meta', '')
    @vite("resources/css/app.css")
    <script defer src="script.js"></script>
    <script type="application/ld+json">
        {!! json_encode([
          '@context' => 'https://schema.org',
          '@type' => 'Blog',
          'name' => 'Komeyl Ajamy Blog',
          'url' => url('/blog'),
          'description' => 'A blog about software development, design, and tech.',
          'publisher' => [
            '@type' => 'Person',
            'name' => 'Komeil Ajamy'
          ]
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        
    @stack('style')
</head>
<body class="flex flex-col min-h-screen {{ app()->currentLocale() == 'fa' ? 'vazir-regular' : 'roboto-regular' }} bg-gray-100 text-gray-900">
    <!-- Header -->
    @include('components.layouts.partials.blog.header')

    {{ $slot }}

    <!-- Footer -->
    @include('components.layouts.partials.footer')
    @stack('javascript')
</body>
</html>
