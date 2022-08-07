<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUser();
    public function getShippers();
    public function getUserById($id);
    public function deleteUser($id);
    public function createUser($request, $role_type);
    public function updateUser($id, $request);
}
