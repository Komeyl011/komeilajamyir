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
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white {{ app()->currentLocale() == 'fa' ? 'vazir-regular' : 'roboto-regular' }}">
    <div x-data="{ open: false }">
        <div 
            x-show="open || window.innerWidth >= 1024"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0"
            class="w-full lg:w-fit fixed top-0 lg:top-1/2 lg:start-5 z-50 bg-white dark:bg-gray-600 dark:shadow-white/30 text-gray-800 dark:text-white shadow-lg dark:shadow-md lg:rounded-xl p-4 space-y-4
                    lg:transform lg:-translate-y-1/2"
            :class="{ 'hidden': !open && window.innerWidth < 1024 }"
        >
            <div class="text-center shadow-sm">
                <livewire:language-switcher />
            </div>
            @include('components.layouts.partials.change-theme-btn')

            <div class="absolute right-0 bottom-0 w-full translate-y-full lg:hidden">
                <button 
                    @click="open = false"
                    class="bg-gray-300 dark:bg-gray-700 p-2 w-full shadow-md text-center"
                    aria-label="Close"
                >
                    <i class="fa-solid fa-angle-up"></i>
                </button>
            </div>
        </div>

        <template x-if="!open">
            <div class="fixed top-0 left-0 w-full z-40 flex justify-center lg:hidden">
                <button 
                    @click="open = true"
                    class="bg-gray-300 dark:bg-gray-700 p-2 w-full shadow-md text-center"
                    aria-label="Open"
                >
                    <i class="fa-solid fa-angle-down"></i>
                </button>
            </div>
        </template>
    </div>

<!-- Hero Section -->
@include('components.layouts.partials.header')

<!-- Main Content -->
{{ $slot }}

<!-- Footer -->
@include('components.layouts.partials.footer')

<script src="https://kit.fontawesome.com/57a53d4203.js" crossorigin="anonymous"></script>
</body>
</html>
