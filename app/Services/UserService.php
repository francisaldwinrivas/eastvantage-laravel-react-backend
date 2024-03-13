<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create new user
     *
     * @param Array $data
     * @return bool|User
     */
    public function create(Array $data) : bool|User
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $user = $this->user->create($data);
            $user->roles()->attach($data['roles']);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return false;
        }
    }

    /**
     * Returns the list of Users
     *
     * @return LengthAwarePaginator
     */
    // public function list(): LengthAwarePaginator
    // {
    //     $perPage = config('user.pagination.per_page');
    //     $users = $this->user->paginate($perPage);

    //     return $users;
    // }

    public function list()
    {
        $users = $this->user->all();
        return new UserCollection($users);
    }

    /**
     * Find user by id
     * @param int $id
     *
     * @return UserResource
     */
    public function find(int $id): UserResource
    {
        $user = $this->user->findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Delete user by id
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        DB::beginTransaction();

        try {
            $user = $this->user->findOrFail($id);
            $user->roles()->detach();
            $user->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();

            return false;
        }
    }

    /**
     * Update user by id
     * @param int $id
     * @param array $user
     *
     * @return bool
     */
    public function update(int $id, array $userDetails)
    {
        DB::beginTransaction();

        try {
            $user = $this->user->findOrFail($id);
            $user->update($userDetails);
            $user->roles()->sync($userDetails['roles']);

            DB::commit();

            return new UserResource($user);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();

            return false;
        }
    }
}
