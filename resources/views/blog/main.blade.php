<section class="my-24">
    <div class="md:hidden w-1/4 mx-auto">
        <form action="{{ route('language.change') }}" method="post">
            @csrf
            <select onchange="this.form.submit()" name="lang"
                    class="block w-30 mt-1 p-2 border border-gray-300 bg-transparent rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                {{--    <option value="" disabled selected>Select a language</option>--}}
                <option value="en" {{ app()->currentLocale() == 'en' ? 'selected' : '' }}>English</option>
                <option value="fa" dir="rtl" {{ app()->currentLocale() == 'fa' ? 'selected' : '' }}>فارسی</option>
            </select>
        </form>
    </div>
    <!-- Search Bar for Mobile -->
    <div class="bg-white p-4 shadow-md md:hidden">
        <form action="#" id="searchForm" method="get" class="relative">
            <input type="text" id="searchInput" placeholder="{{ __('blog_main.search_bar') }}"
                   class="w-full py-2 px-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="absolute {{ app()->currentLocale() == 'fa' ? 'left-2' : 'right-2' }} top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 15.172A6 6 0 1118.828 11a6 6 0 01-3.656 4.172zM21 21l-4.35-4.35"></path>
                </svg>
            </button>
        </form>
    </div>

    <!-- Filter and Blog Posts -->
    <main class="container mx-auto p-6">
        <!-- Search Bar for Desktop -->
        <div class="hidden md:block bg-white p-4 shadow-md mb-6">
            <form wire:submit.prevent="searchPosts()" id="searchForm" class="relative">
                <input type="text" id="searchInput" wire:model="search" wire:change="searchPosts()" placeholder="{{ __('blog_main.search_bar') }}"
                       class="w-full py-2 px-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="absolute {{ app()->currentLocale() == 'fa' ? 'left-2' : 'right-2' }} top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 15.172A6 6 0 1118.828 11a6 6 0 01-3.656 4.172zM21 21l-4.35-4.35"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Filter Options -->
        <div class="mb-6 flex justify-between items-center">
            <form>
                <div class="flex space-x-4">
                    <select wire:model="filter" wire:change="changeFilter()" id="categoryFilter"
                            class="py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('blog_main.filter_default') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
{{--                    <select id="tagFilter" class="py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">--}}
{{--                        <option value="">All Tags</option>--}}
{{--                        <option value="web">Web Development</option>--}}
{{--                        <option value="design">Design</option>--}}
{{--                        <option value="career">Career</option>--}}
{{--                    </select>--}}
                </div>
            </form>
        </div>

        <!-- Blog Posts Grid -->
        <div id="blogPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <!-- Blog Post Card -->
            @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ Storage::url($post->image) }}" alt="{{ json_decode($post->title)->{app()->currentLocale()} }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2"><a href="{{ route('blog.post.show', ['slug' => $post->slug]) }}" class="text-blue-600 hover:underline">{{ json_decode($post->title)->{app()->currentLocale()} }}</a></h2>
                        <p class="text-gray-600 mb-4">
                            @php
                                $translation = \App\Models\PostTranslation::query()->where('post_id', '=', $post->id)->where('locale', '=', app()->currentLocale())->first();
                                //dd($translation, app()->currentLocale());
                            @endphp
                            {{ $translation->excerpt }}
                        </p>
                        <a href="{{ route('blog.post.show', ['slug' => $post->slug]) }}" class="text-blue-600 hover:underline">{{ __('mainsections.post_read_more') }}</a>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $posts->links() }}
{{--        <div id="pagination" class="mt-8 flex justify-center">--}}
{{--            <button class="py-2 px-4 border border-gray-300 rounded-lg bg-white text-blue-600 hover:bg-blue-50">Previous</button>--}}
{{--            <button class="py-2 px-4 border border-gray-300 rounded-lg bg-white text-blue-600 hover:bg-blue-50 ml-2">Next</button>--}}
{{--        </div>--}}
    </main>
</section>
