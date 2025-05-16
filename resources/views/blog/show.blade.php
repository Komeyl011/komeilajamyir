@section('title', json_decode($post->seo_title)->{app()->currentLocale()})
@section('meta')
    <meta name="description" content="{{ json_decode($post->meta_description)->{app()->currentLocale()} }}">
    <meta name="keywords" content="{{ json_decode($post->meta_keywords)->{app()->currentLocale()} }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => json_decode($post->title)->{app()->currentLocale()},
            'image' => Storage::url($post->image),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name
            ],
            'datePublished' => $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'description' => $post_translation->excerpt,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.post.show', ['slug' => $post->slug])
            ]
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@php
    $created_at = explode(' ', $post->created_at);
    $updated_at = $post->created_at == $post->updated_at
        ? null
        : explode(' ', $post->updated_at);
    if (app()->currentLocale() == 'fa') {
        $persianFormatter = new \IntlDateFormatter(
            "fa_IR@calendar=persian",
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            'Asia/Tehran',
            \IntlDateFormatter::TRADITIONAL,
            'd MMMM، yyyy'
        );
    }
    $created_at = new DateTime($created_at[0]);
    $created_at = ! isset($persianFormatter)
        ? $created_at->format('F j, Y')
        : $persianFormatter->format($created_at);
    if (! is_null($updated_at)) {
        $updated_at = new DateTime($updated_at[0]);
        $updated_at = ! isset($persianFormatter)
            ? $updated_at->format('F j, Y')
            : $persianFormatter->format($updated_at);
    }
@endphp
<!-- Main Content -->
<main class="container mx-auto mt-24 p-4 bg-white shadow-md rounded-lg">
    <!-- Blog Post Title -->
    <h1 class="text-4xl font-bold text-gray-800">{{ json_decode($post->title)->{app()->currentLocale()} }}</h1>
    <p class="text-sm text-gray-500 mt-2">@lang('blog_main.post.posted_by', ['name' => $post->author->name, 'date' => $created_at])</p>
    <span class="text-sm text-gray-500 mt-2">{{ ! is_null($updated_at) ? __('blog_main.post.updated_at', ['date' => $updated_at]) : '' }}</span>
    <span class="text-sm text-gray-500 mt-2 ms-3">@lang('blog_main.post.read_time', ['minutes' => $post_translation->readTime])</span>

    <!-- Featured Image -->
    <img src="{{ Storage::disk('liara')->url($post->image) }}" alt="{{ json_decode($post->title)->{app()->currentLocale()} }}" class="w-full mt-6 rounded-lg">

    <!-- Blog Post Content -->
    <article class="mt-10 text-gray-700" style="line-height: 2rem">
        {!! $post_translation->excerpt !!}
        {!! $post_translation->body !!}
    </article>

    {{-- Tags --}}
{{--    <div class="mt-8">--}}
{{--        <span class="text-gray-600 font-semibold">Tags:</span>--}}
{{--        <a href="#" class="text-blue-600 hover:underline mx-2">#WebDevelopment</a>--}}
{{--        <a href="#" class="text-blue-600 hover:underline mx-2">#TailwindCSS</a>--}}
{{--        <a href="#" class="text-blue-600 hover:underline mx-2">#JavaScript</a>--}}
{{--    </div>--}}

    {{-- Comments Section --}}
{{--    <section class="mt-10">--}}
{{--        <h2 class="text-2xl font-bold text-gray-800">Comments</h2>--}}

{{--        <div id="comments" class="mt-6 space-y-6">--}}
{{--            <!-- Example Comment -->--}}
{{--            <div class="flex items-start space-x-4">--}}
{{--                <img src="https://via.placeholder.com/50" alt="Avatar" class="w-12 h-12 rounded-full">--}}
{{--                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex-1">--}}
{{--                    <div class="flex justify-between">--}}
{{--                        <h3 class="font-semibold text-gray-800">John Doe</h3>--}}
{{--                        <span class="text-gray-500 text-sm">2 hours ago</span>--}}
{{--                    </div>--}}
{{--                    <p class="text-gray-700 mt-2">Great post! Very informative.</p>--}}
{{--                    <div class="mt-2 flex items-center space-x-4 text-gray-500">--}}
{{--                        <button class="hover:text-blue-600">Reply</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Comment Form -->--}}
{{--        <form id="commentForm" class="mt-6 bg-gray-50 p-6 rounded-lg shadow-lg">--}}
{{--            <h3 class="text-xl font-semibold text-gray-800 mb-4">Leave a Comment</h3>--}}
{{--            <input type="text" id="commentName" placeholder="Your Name" class="w-full p-3 border rounded-lg mb-3 focus:outline-none focus:ring-2 focus:ring-blue-600">--}}
{{--            <textarea id="commentText" rows="4" placeholder="Your Comment" class="w-full p-3 border rounded-lg mb-3 focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>--}}
{{--            <button type="button" onclick="addComment()" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">Post Comment</button>--}}
{{--        </form>--}}
{{--    </section>--}}
</main>
