<?php

namespace App\Interfaces;

interface RoleRepositoryInterface
{
    public function getAllRoles();
    public function getRoleById($Id);
    public function deleteRole($Id);
    public function createRole($request);
    public function updateRole($Id, $request);
    public function permissions();
}
