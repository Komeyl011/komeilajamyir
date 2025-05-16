<?php

namespace App\Http\Controllers\CafeMenuApi;

use App\Http\Controllers\CafeMenuApi\ApiMainController;
use App\Http\Resources\UserResource;
use App\Models\CafeMenuApi\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiMainController
{
    public function __construct()
    {
        $this->modelClass = User::class;
        $this->resourceClass = UserResource::class;

        parent::__construct();
    }

    /**
     * Return all of the users
     */
    public function index()
    {
        $response = $this->showAll();
        return response()->json($response, $response['status']);
    }

    /**
     * Store a user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('fname', 'lname', 'email', 'phone_number', 'password'), [
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'phone_number' => ['required', 'unique:users,phone_number', 'regex:/^(\\+98|0)[0-9]{10}$/'], // regex for Iranian phone number
            'password' => 'required|string|min:8',
        ], [
            'phone_number.regex' => 'The phone number format is invalid. It should start with +98 or 0 followed by 10 digits.',
        ]);

        if ($validator->fails()) {
            $errors = $this->validation_error($validator->errors());
            return response()->json($errors, $errors['status']);
        }

        $all = $validator->validated();

        $response = $this->save($all);
        return response()->json($response, $response['status']);
    }

    /**
     * Show a single User's info
     */
    public function show(int $user)
    {
        $response = $this->showSingle($user);

        return response()->json($response, $response['status']);
    }

    /**
     * Update user
     */
    public function update(Request $request, int $user)
    {
        $validator = Validator::make($request->only('fname', 'lname', 'email', 'phone_number'), [
            'fname' => 'string|max:50',
            'lname' => 'string|max:50',
            'email' => ['email', 'unique:users,email'],
            'phone_number' => ['regex:/^(\\+98|0)[0-9]{10}$/', 'unique:users,phone_number'], // regex for Iranian phone number
        ]);

        if ($validator->fails()) {
            $errors = $this->validation_error($validator->errors());
            return response()->json($errors, $errors['status']);
        }

        $validated = $validator->validated();

        $response = $this->edit($user, $validated);

        return response()->json($response, $response['status']);
    }

    /**
     * Delete the requested user
     */
    public function destroy(int $user)
    {
        $response = $this->delete($user);

        return response()->json($response, $response['status']);
    }

    /**
     * Login request handler
     */
    public function login(Request $request)
    {
        $validate = $this->validateData($request->only(['uid', 'password']), [
            'uid' => 'string|max:50',
            'password' => 'string',
        ]);

        if (!is_array($validate))
            return $validate;

        if ($request->query('uid') && $request->query('password')) {
            $response = [
                'status' => 406,
                'message' => 'This request is not approved.',
            ];
        } else {
            $credentials = [
                'uid' => $request->input('uid'),
                'password' => $request->input('password'),
            ];

            if ($this->isEmail($credentials['uid'])) {
                $credentials = ['email' => $credentials['uid']] + $credentials;
                unset($credentials['uid']);
            } elseif ($this->isPhoneNumber($credentials['uid'])) {
                $credentials = ['phone_number' => $credentials['uid']] + $credentials;
                unset($credentials['uid']);
            } else {
                return response()->json([
                    'status' => 406,
                    'message' => 'Wrong uid',
                ], 403);
            }

            if (!$this->guard()->validate($credentials)) {
                $response = [
                    'status' => 404,
                    'message' => 'Wrong username or password',
                ];
            } else {
                $user = Auth::getProvider()->retrieveByCredentials($credentials);

                $expiration = \Carbon\Carbon::now()->addHours(4);
                $token = $user->createToken('Login-session', ['user'], $expiration)->plainTextToken;

                $response = [
                    'status' => 200,
                    'message' => 'Login successful, token created.',
                    'user' => $user->fname . ' ' . $user->lname,
                    'token' => $token,
                ];

                Auth::login($user);
            }
        }

        return response()->json($response, $response['status']);
    }

    /**
     * Register request handler
     */
    public function register(Request $request)
    {
        return $this->store($request);
    }

    private function guard()
    {
        return Auth::guard();
    }

    private function isEmail($string): bool
    {
        $validator = Validator::make(['uid' => $string], [
            'uid' => 'email:rfc,dns',
        ]);

        return !$validator->fails();
    }

    private function isPhoneNumber($string): bool
    {
        $validator = Validator::make(['uid' => $string], [
            'uid' => ['regex:/^(09\d{2})\d{7}$|^(0\d{2})\d{7}$/'],
        ]);

        return !$validator->fails();
    }
}
