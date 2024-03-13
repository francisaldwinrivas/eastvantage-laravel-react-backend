<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Retrieves the list of Users
     */
    public function index()
    {
        $users = $this->userService->list();

        return response()->json($users);
    }

    /**
     * Create new user
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->create($request->only('name', 'email', 'password', 'roles'));

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

    /**
     * Retrieves single User
     *
     * @param int $id
     */
    public function show($id)
    {
        $user = $this->userService->find($id);

        return response()->json([
            'data' => $user
        ]);
    }
}
