<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\RegistrationRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Services\UserService;
use App\Services\LoginService;

class AuthController extends Controller
{
    public $userService, $loginService;

    public function __construct(UserService $userService, LoginService $loginService)
    {
        $this->userService = $userService;
        $this->loginService = $loginService;
    }

    public function register(RegistrationRequest $request)
    {
        $user = $this->userService->create($request->only('name', 'email', 'password'));

        if(!$user)
            return response()->json(array(
                'success' => false,
                'message' => "Registration failed. An error occurred during the registration process."
            ));

        return response()->json(array(
            'success' => true,
            'message' => "User has been successfully registered."
        ));
    }

    public function login(LoginRequest $request)
    {
        $accessToken = $this->loginService->login($request->only('email', 'password'));

        if(!$accessToken)
            return response()->json(array(
                'success' => false,
                'message' => "Login Failed. Please check your credentials"
            ));

        return response()->json(array(
            'success' => true,
            'access_token' => $accessToken,
            'message' => "User has successfully logged in."
        ));
    }
}
