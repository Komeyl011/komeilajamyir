<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/bot/6713833321:AAGv2SeCiy6WEvNpK0iArB8xNrDzbqjgEls',
        '/bot/7536836506:AAFfSsCJnWPB4Tr7E2PD_7EkmgX3Myf_NhU',
        '/bot/8174676654:AAGfnL1H74NOBQvxKB-HuBTtQ0Z6HmgA-tQ',
    ];
}
