<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{

    public function getAllUsers()
    {
        return User::all();
    }
    public function findUserById(int $id): ?User
    {
        return User::with("Bookings")->find($id);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }
    public function updateUser(int $id, array $data): bool
    {
        $user = $this->findUserById($id);

        if ($user) {
            return $user->update($data);
        }

        return false;
    }
    public function deleteUser(int $id): bool
    {
        $user = $this->findUserById($id);

        if ($user) {
            return $user->delete();
        }

        return false;
    }
}
