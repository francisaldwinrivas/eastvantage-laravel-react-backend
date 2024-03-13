<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Grant/Generate access token for the user
     *
     * @param Array $credentials
     * @return bool|string
     */
    public function login(Array $credentials) : bool|array
    {
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('eastvantageToken')->accessToken;

            return [
                'user' => new UserResource($user),
                'accessToken' => $accessToken
            ];
        }

        return false;
    }

}
