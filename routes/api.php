<?php

use App\Http\Controllers\CafeMenuApi\BusinessController;
use App\Http\Controllers\CafeMenuApi\PaymentController;
use App\Http\Controllers\CafeMenuApi\UserController;
use App\Http\Controllers\CafeMenuApi\PlanController;
use App\Http\Controllers\CafeMenuApi\SubscriptionController;
use App\Http\Middleware\CafeMenuApi\CheckAbilities;
use App\Http\Middleware\CafeMenuApi\VerifyApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Laravel\Sanctum\Http\Middleware\CheckAbilities;

Route::middleware(VerifyApiToken::class)->group(function () {
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');

    Route::get('/', function () {
        return response()->json([
            'status' => 404,
            'message' => 'The endpoint you requested does not exist',
        ], 404);
    });

    Route::apiResource(name: 'users', controller: UserController::class);
    Route::apiResource(name: 'plans', controller: PlanController::class);
    Route::apiResource(name: 'subscriptions', controller: SubscriptionController::class);
    Route::apiResource(name: 'payments', controller: PaymentController::class);
    Route::apiResource(name: 'businesses', controller: BusinessController::class);

    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register'])->name('register');
});


// Route::post('/create_token', function (Request $request) {
//     if ($request->has('id')) {
//         $user = \App\Models\CafeMenuApi\User::query()->find($request->query('id'));
//         // dd($user);
//     } else {
//         return response()->json([
//             'status' => 400,
//             'result' => 'All the necessary fields must be provided.',
//         ], 400);
//     }

//     if ($user->count() <= 0) {
//         return response()->json([
//             'status' => 404,
//             'result' => 'User not found.',
//         ], 404);
//     }
//     // \Illuminate\Support\Facades\Auth::guard()->loginUsingId($request->query('id'));
//     // dd(\Illuminate\Support\Facades\Auth::guard()->check());
//     $expiration = \Carbon\Carbon::now()->addYear();
//     $token = $user->createToken('MyApp', ['*'], $expiration)->plainTextToken;
//     $data = [
//         'status' => 200,
//         'user' => $user->name,
//         'token' => $token,
//     ];

//     return response()->json($data, 200);
//     // public endpoints access token => "8|OMjcs8tUkwah5xc0JQsOMmtBXtZP5NCMwrSHlc2D2b6b3c26"
//     // protected endpoints access token => "9|dJ2fYZOaELL3PvUGd0PZ2QbjMYmF2DMcjep6yTNP1ec54768"
// });