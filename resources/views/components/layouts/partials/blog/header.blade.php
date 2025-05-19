@php
    $locale = app()->currentLocale();
@endphp
<header class="fixed top-10 md:top-0 w-full bg-gray-800 text-white p-4" style="z-index: 1">
    <div class="container mx-auto flex justify-between items-center">
        <h1><a href="{{ route('blog.home') }}" class="text-3xl font-bold">{{ $locale == 'fa' ? 'بلاگ کمیل عجمی' : 'Komeil Ajamy Blog' }}</a></h1>
        <nav class="hidden md:flex md:items-center @if($locale != 'fa') space-x-4 @else md:justify-around @endif">
            <a href="{{ route('blog.home') }}" class="hover:underline @if($locale == 'fa') ml-3 @endif">{{ __('blog_main.nav_item_home') }}</a>
            <a href="{{ route('home') }}#about" class="hover:underline @if($locale == 'fa') ml-3 @endif">{{ __('blog_main.nav_item_about') }}</a>
            <a href="{{ route('home') }}#contact" class="hover:underline @if($locale == 'fa') ml-3 @endif">{{ __('blog_main.nav_item_contact') }}</a>
            @section("bg-color", 'bg-gray-800')
        </nav>
    </div>
</header>
