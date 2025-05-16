<div dir="{{ app()->isLocale('fa') ? 'rtl' : 'ltr' }}">
    <x-mail::message>
        {{-- Greeting --}}
        @if (! empty($greeting))
        # {{ $greeting }}
        @else
        @if ($level === 'error')
        # @lang('mail.greeting_err')
        @else
        # @lang('mail.greeting_hello')
        @endif
        @endif

        {{-- Intro Lines --}}
        @foreach ($introLines as $line)
        {{ $line }}

        @endforeach

        {{-- Action Button --}}
        @isset($actionText)
        <?php
            $color = match ($level) {
                'success', 'error' => $level,
                default => 'primary',
            };
        ?>
        <x-mail::button :url="$actionUrl" :color="$color">
        {{ $actionText }}
        </x-mail::button>
        @endisset

        {{-- Outro Lines --}}
        @foreach ($outroLines as $line)
        {{ $line }}

        @endforeach

        {{-- Salutation --}}
        @if (! empty($salutation))
            {{ $salutation }}
        @else
            @lang('mail.regards')<br>
            @lang('mail.brand')
        @endif

        {{-- Subcopy --}}
        @isset($actionText)
        <x-slot:subcopy>
        @lang(
            'mail.trouble_clicking',
            [
                'actionText' => $actionText,
            ]
        ) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
        </x-slot:subcopy>
        @endisset
    </x-mail::message>
</div>