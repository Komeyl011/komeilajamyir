<?php

namespace App\Livewire;

use App\Http\Middleware\LanguageMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $default_btn_bg = 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-black';
    public $selected_btn_bg = 'bg-indigo-500 dark:bg-indigo-800 hover:bg-indigo-600 text-white';
    public $currentLocale;

    public function switchLanguage($lang)
    {
        $locales = LanguageMiddleware::scanLanguages();

        if (!in_array($lang, $locales)) {
            return redirect()->back();
        }

        $this->currentLocale = app()->currentLocale();
        Session::put('locale', $lang);
        App::setLocale($lang);

        return redirect(request()->header('Referer') ?? '/');
    }

    public function render()
    {
        $this->currentLocale = app()->currentLocale();
        return view('components.layouts.partials.change-lang');
    }
}
