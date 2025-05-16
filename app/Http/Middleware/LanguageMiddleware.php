<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(session('locale') ?? app()->currentLocale());
        app()->setLocale(session('locale') ?? app()->currentLocale());

        return $next($request);
    }

    /**
     * Scan languages folder and return list of available languages
     *
     * @return array
     */
    public static function scanLanguages(): array
    {
        $filtered = ['.', '..'];

        $dirs = [];
        $d = dir(resource_path('lang'));

        while (($entry = $d->read()) !== false) {
            if (is_dir(resource_path('lang').'/'.$entry) && !in_array($entry, $filtered) && $entry != 'vendor') {
                $dirs[] = $entry;
            }
        }

        return $dirs;
    }

    /**
     * Return the list of locales
     */
    public static function listLocales(): array
    {

    }
}
