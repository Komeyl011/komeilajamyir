<?php

namespace App\Http\Middleware\CafeMenuApi;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckAbilities
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('menu-gen-key');

        if (!$token) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized Request.',
            ], 401);
        }

        $token_exists = PersonalAccessToken::findToken($token);
//        dd($token_exists, $token_exists->expires_at < now());
        if ($token_exists && (in_array('public', $token_exists->abilities) || in_array('*', $token_exists->abilities))) {
            if ($token_exists->expires_at > now()) {
                Auth::login($token_exists->tokenable);
            } else {
                return response()->json([
                    'status' => 401,
                    'error' => 'Your token has expired.',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'error' => 'You do not have necessary permissions for this endpoint.',
            ], 401);
        }
        return $next($request);
    }
}
