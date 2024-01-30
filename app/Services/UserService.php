<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function allUser()
    {
        return User::all();
    }

    public function getUser($UserId)
    {
        return User::findOrFail($UserId);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($UserId, array $data)
    {
        $Users = $this->getUser($UserId);
        $Users->update($data);

        return $Users;
    }

    public function deleteUser($UserId)
    {
        $Users = $this->getUser($UserId);
        $Users->delete();

        return $Users;
    }
    
}   