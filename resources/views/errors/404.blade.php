<!doctype html>
<html lang="{{ app()->currentLocale() }}" dir="{{ app()->currentLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Not Found</title>
    <link rel='stylesheet' href='{{ asset('./bootstrap.css') }}'>
    @vite('resources/css/app.css')
</head>
<body class="sahel">
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg" style="background-image: url('{{ Storage::disk('liara')->url('assets/404_1.gif') }}')">
                            <h1 class="text-center ">404</h1>
                        </div>

                        <div class="contant_box_404">
                            <h3 class="h2">
                                {{ __('errors.404_title') }}
                            </h3>

                            <p>
                                {{ __('errors.404_not_found_txt') }}
                            </p>

                            <a href="{{ route('home') }}" class="link_404">{{ __('errors.go_home') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
