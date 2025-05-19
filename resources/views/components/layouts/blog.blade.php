<!DOCTYPE html>
<html lang="{{ app()->currentLocale() }}" dir="{{ app()->currentLocale() == 'fa' ? 'rtl' : 'ltr' }}" class="min-h-screen flex flex-col">
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
<body class="flex flex-col min-h-screen {{ app()->currentLocale() == 'fa' ? 'vazir-regular' : 'roboto-regular' }} bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-white">
    <div x-data="{ open: false }">
        <div 
            x-show="open || window.innerWidth >= 1024"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0"
            class="w-full lg:w-fit fixed top-0 lg:top-1/2 lg:start-5 z-50 bg-white dark:bg-gray-600 dark:shadow-white/30 text-gray-800 dark:text-white shadow-lg
                    dark:shadow-md lg:rounded-xl p-4 space-y-4 lg:transform lg:-translate-y-1/2"
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

    <!-- Header -->
    @include('components.layouts.partials.blog.header')

    {{ $slot }}

    <!-- Footer -->
    @include('components.layouts.partials.footer')

    <script src="https://kit.fontawesome.com/57a53d4203.js" crossorigin="anonymous"></script>
    @stack('javascript')
    @vite('resources/js/app.js')
</body>
</html>
