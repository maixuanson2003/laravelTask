<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    /**
     * Get a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUserById(int $id): bool
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }

        return false;
    }
}
