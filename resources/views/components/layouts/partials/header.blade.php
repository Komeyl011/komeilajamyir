<header class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white h-screen flex items-center justify-center">
    <div class="absolute inset-0 bg-cover" style="background-image: url({{ Storage::disk('liara')->url('assets/hero-bg.jpg') }});"></div>
    <!-- Dark Transparent Overlay -->
    <div class="absolute inset-0 bg-black opacity-70"></div>
    <div class="relative z-1 text-center p-6">
        <h1 class="text-5xl font-bold mb-4">{{ __('main.hero-name') }}</h1>
        <p class="text-xl mb-8">{{ __('main.hero-title') }}</p>
        <a href="#contact" class="bg-blue-600 dark:bg-cyan-500 dark:hover:bg-cyan-800 text-white py-4 px-6 rounded-lg shadow-lg hover:bg-blue-700 transition">{{ __('main.hero-button') }}</a>
    </div>
</header>
