<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('mail.brand')</title>
    @vite('resources/css/mail/themes/mail.css')
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        @font-face {
            font-family: Vazirmatn;
            src: url('https://tims.storage.c2.liara.space/assets/fonts/Vazirmatn-Regular.woff2') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Sahel";
            font-weight: bold;
            src: url('https://tims.storage.c2.liara.space/assets/fonts/Sahel/Sahel-Bold.woff') format('woff');
        }

        body {
            background-color: #f3f4f6;
            color: #111827;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-family: Vazirmatn, serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: Sahel, serif;
        }

        table {
            width: 100%;
            padding: 2rem 1rem;
            border-collapse: collapse;
        }

        .email-container {
            width: 100%;
            max-width: 36rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1),
                        0 1px 2px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .email-header {
            background-color: #164e63;
            color: white;
            text-align: center;
            font-size: 30px;
            line-height: 2.5rem;
            font-weight: bold;
            padding: 2rem 1.5rem;
        }

        .email-body {
            padding: 2rem 1.5rem 0 1.5rem;
            font-size: 15px;
            line-height: 1.625rem;
        }

        .email-content {
            padding-top: 0;
        }

        .email-footer {
            background-color: #f3f4f6;
            color: #4b5563;
            font-size: 0.75rem;
            text-align: center;
            padding: 1rem 1.5rem;
        }

        .email-footer a {
            color: #3b82f6;
            text-decoration: none;
            word-break: break-all;
        }

        .email-footer p {
            margin-top: 0.5rem;
        }

        .notification_header {
            font-size: 22px;
            line-height: 1.75rem;
            padding: 1rem 0 1rem;
        }

        .notification_content {
            font-size: 16px;
            line-height: 1.75rem;
            padding: 1rem 0 1.5rem;
        }

        .action-button-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2rem 0;
        }

        .action-button {
            font-family: Sahel, serif;
            background-color: #0e7490;
            padding: 0.75rem 1.25rem;
            color: #ffffff;
            text-decoration: none;
            border-radius: 0.375rem;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-button:hover {
            background-color: #0891b2;
        }
    </style>
</head>
<body dir="{{ $locale == 'fa' ? 'rtl' : 'ltr' }}">
    <table dir="{{ $locale == 'fa' ? 'rtl' : 'ltr' }}">
        <tr>
            <td align="center">
                <table class="email-container">
                    <tr>
                        <td class="email-header">
                            <h2>@lang('mail.brand')</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-body">
                            @if(!isset($greeting))
                                <p>@lang('mail.greeting_hello', ['name' => $name])</p>
                            @else
                                <p>{{ $greeting }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="email-body email-content">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td class="email-footer">
                            <p>@lang('mail.regards')</p>
                            @lang('mail.all_rights', ['year' => now()->year])
                        </td>
                    </tr>
                    @if(isset($action_btn))
                        <tr>
                            <td class="email-footer">
                                @lang('mail.trouble_clicking', ['actionText' => $action_btn['text'] ?? __("mail.action_btn_txt")])
                                <p><a href="{{ $action_btn['url'] }}" target="_blank">{{ $action_btn['url'] }}</a></p>
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
