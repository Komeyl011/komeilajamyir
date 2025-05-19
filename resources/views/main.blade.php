<main class="container mx-auto p-6 md:p-12">
    <!-- About Me -->
    <section id="about" class="mb-12 md:flex md:space-x-8">
        <div class="md:w-1/3">
            <img src="{!! Storage::disk('liara')->url($about->image) !!}" alt="Komeyl Ajamy" class="w-full rounded-full shadow-lg">
        </div>
        <div class="md:w-2/3 mt-4 md:mt-0">
            <h1 class="text-3xl font-semibold mb-4">{{ __('mainsections.aboutmetitle') }}</h1>
            <p class="text-lg leading-relaxed">{!! json_decode($about->description)->{app()->currentLocale()} !!}</p>
        </div>
    </section>

    <!-- Experience -->
    <section id="experience" class="mb-12">
        <h2 class="text-3xl font-semibold mb-4">{{ __('mainsections.experiencestitle') }}</h2>
        @foreach($experiences as $experience)
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-600 p-6 rounded-lg shadow-lg mb-2">
                    <h3 class="text-xl font-semibold">{{ json_decode($experience->job_title)->{app()->currentLocale()} }} -
                        {{ json_decode($experience->company)->{app()->currentLocale()} }}</h3>
                    @if(app()->currentLocale() === 'fa')
                        @php
                            $persianFormatter = new \IntlDateFormatter(
                                "fa_IR@calendar=persian",
                                \IntlDateFormatter::FULL,
                                \IntlDateFormatter::FULL,
                                'Asia/Tehran',
                                \IntlDateFormatter::TRADITIONAL,
                                'yyyy/MM/dd'
                            );
                            $from = DateTime::createFromFormat('Y-m-d', $experience->from);
                            $to = DateTime::createFromFormat('Y-m-d', $experience->to);
                        @endphp
                        <p class="text-gray-600 dark:text-white">{{ $persianFormatter->format($from) . ' تا ' . $persianFormatter->format($to) }}</p>
                    @else
                        <p class="text-gray-600 dark:text-white">{{ $experience->from . ' to ' . $experience->to }}</p>
                    @endif
{{--                    <p class="mt-2">Brief description of your role and achievements. Highlight your key responsibilities and successes.</p>--}}
                </div>
                <!-- Repeat similar blocks for each job -->
            </div>
        @endforeach
    </section>

    <!-- Skills -->
    @if($skills->count() > 0)
        <section id="skills" class="mb-12">
            <h2 class="text-3xl font-semibold mb-4">{{ __('mainsections.skillstitle') }}</h2>
            <div class="space-y-6">
                @foreach($skills as $skill)
                    <div class="bg-white dark:bg-gray-600 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">{{ $skill->skill_name }}</h3>
    {{--                    <p>Description or proficiency level.</p>--}}
                        <div class="relative pt-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium">{{ $skill->proficiency }}%</span>
                            </div>
                            <div class="flex bg-gray-200 dark:bg-gray-300 rounded-full h-3">
                                <div class="bg-blue-600 dark:bg-cyan-500 h-full rounded-full" style="width: {!! (int)$skill->proficiency !!}%;"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Portfolio -->
    @if($portfolio->count() > 0)
        <section id="portfolio" class="mb-12">
            <h2 class="text-3xl font-semibold mb-4">{{ __('mainsections.portfoliotitle') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portfolio as $project)
                    <div class="bg-white dark:bg-gray-600 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ Storage::disk('liara')->url($project->thumbnail) }}" alt="{{ json_decode($project->title)->{app()->currentLocale()} }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ json_decode($project->title)->{app()->currentLocale()} }}</h3>
                            <p class="text-gray-600 dark:text-white mb-4">{{ json_decode($project->description)->{app()->currentLocale()} }}</p>
                            <a href="{{ $project->slug }}" target="__blank" class="text-blue-600 hover:underline">{{ __('mainsections.viewproject') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Blog Posts -->
    @if($blog_posts->count() > 0)
        <section id="blog" class="mb-12">
            <h2 class="mb-8"><a href="{{ route('blog.home') }}" class="text-3xl font-semibold hover:underline hover:text-blue-500 dark:hover:text-cyan-500">{{ __('mainsections.latestposts') }}</a></h2>
            <div class="space-y-6">
                @forelse($blog_posts as $post)
                    <div class="bg-white dark:bg-gray-600 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-2">
                            <a href="{{ route('blog.post.show', ['slug' => $post->slug]) }}" class="text-blue-600 dark:text-cyan-500 hover:underline">
                                {{ json_decode($post->title)->{app()->currentLocale()} }}
                            </a>
                        </h3>
                        <p class="text-gray-600 dark:text-white mb-4">
                            {{ \App\Models\PostTranslation::query()->where('post_id', '=', $post->id)->where('locale', '=', app()->currentLocale())->first()->excerpt }}
                        </p>
                        <a href="{{ route('blog.post.show', ['slug' => $post->slug]) }}" class="text-blue-600 dark:text-cyan-500 hover:underline">{{ __('mainsections.post_read_more') }}</a>
                    </div>
                @empty
                    <p>No post at the moment!</p>
                @endforelse
            </div>
        </section>
    @else
        <section id="blog" class="mb-12">
            <h2><a href="{{ route('blog.home') }}" class="text-3xl font-semibold hover:text-blue-500 dark:hover:text-cyan-500">{{ __('mainsections.latestposts') }}</a></h2>
        </section>
    @endif

    <!-- Contact -->
    <section id="contact" class="mb-12">
        <h2 class="text-3xl font-semibold mb-4">{{ __('mainsections.contact_title') }}</h2>
        <div class="md:flex md:space-x-8">
            <!-- Contact Information -->
            <div class="md:w-1/2 mb-8 md:mb-0">
                @foreach($contact_info as $ci)
                    @if(strtolower($ci->platform) == 'email')
                        <p class="text-xl mb-4"><i class="mx-4 {{ $ci->icon }}"></i> <a href="mailto:{!! $ci->url !!}" class="text-blue-600 dark:text-cyan-500 hover:underline">{!! $ci->url !!}</a></p>
                    @else
                        <p class="text-xl mb-4"><i class="mx-4 {{ $ci->icon }}"></i> <a href="{!! $ci->url !!}" class="text-blue-600 dark:text-cyan-500 hover:underline capitalize">{!! $ci->platform !!}</a></p>
                    @endif
                @endforeach
            </div>

            <!-- Contact Form -->
            <div class="md:w-1/2 bg-white dark:bg-gray-600 p-8 rounded-lg shadow-lg w-full">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-6">{{ __('mainsections.contact_me_title') }}</h2>
                <form action="{{ route('contact-form.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_locale" value="{{ app()->currentLocale() }}">

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-white font-medium mb-2">{{ __('mainsections.contact_me_name') }}</label>
                        <input type="text" id="name" name="name" {{ old('name') }}
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-200 dark:bg-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-white font-medium mb-2">{{ __('mainsections.contact_me_email') }}</label>
                        <input type="email" id="email" name="email" {{ old('email') }}
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-200 dark:bg-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject" class="block text-gray-700 dark:text-white font-medium mb-2">{{ __('mainsections.contact_me_subject') }}</label>
                        <input type="text" id="subject" name="subject" {{ old('subject') }}
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-200 dark:bg-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    @error('subject')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <!-- Message -->
                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 dark:text-white font-medium mb-2">{{ __('mainsections.contact_me_message') }}</label>
                        <textarea id="message" name="message" rows="5" {{ old('message') }}
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-200 dark:bg-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
                    </div>
                    @error('message')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="w-full bg-blue-500 dark:bg-cyan-500 dark:hover:bg-cyan-800 text-white font-medium py-2 px-4 rounded-lg
                                hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-cyan-700 focus:ring-offset-2 border dark:border-gray-200">
                            {{ __('mainsections.contact_me_submit_btn') }}</button>
                    </div>
                    <div class="text-center">
                        @if(session('success'))
                            <div class="text-green-700 dark:text-green-300 mt-5">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>

</main>
