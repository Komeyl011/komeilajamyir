<div class="flex gap-2 w-full">
    @foreach (App\Http\Middleware\LanguageMiddleware::scanLanguages() as $lang)
        <button 
            wire:click="switchLanguage('{{ $lang }}')" 
            class="flex flex-col justify-center items-center w-full px-3 py-1 rounded {{ $currentLocale === $lang ? $selected_btn_bg : $default_btn_bg }}">
            <img src="https://flagcdn.com/16x12/{{ __("langbtn.flags.{$lang}") }}.png" alt="US flag" class="me-2"> {{ __("langbtn.{$lang}") }}
        </button>
    @endforeach
</div>