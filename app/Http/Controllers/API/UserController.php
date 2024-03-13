<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateUserRequest;
use App\Http\Requests\API\UpdateUserRequest;
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

    public function destroy($id)
    {
        $deleted = $this->userService->delete($id);

        if(!$deleted)
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the user.'
            ]);

        return response()->json([
            'success' => true,
            'message' => 'User has been deleted successfully'
        ]);
    }

    public function update(int $id, UpdateUserRequest $request)
    {
        $user = $this->userService->update($id, $request->only('name', 'email', 'password', 'roles'));

        if(!$user)
            return response()->json([
                'success' => false,
                'message' => 'Failed to update the user.'
            ]);

        return response()->json([
            'success' => false,
            'user' => $user,
            'message' => 'User has been updated successfully'
        ]);
    }
}
