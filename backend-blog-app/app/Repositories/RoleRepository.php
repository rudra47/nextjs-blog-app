<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAllRoles() {
        return $roles = Role::all();
    }

    public function permissions() {
        return $permissions = Permission::with('children')
            ->where('parent_id', null)
            ->get();

    }

    public function getRoleById($Id) {
        return $role = Role::findById($Id);
    }

    public function deleteRole($Id) {
        return $role = Role::destroy($Id);
    }

    public function createRole($request) {
        $role = Role::create([
            'name' => $request->name
        ]);
        $role->givePermissionTo($request->permissions);
        return $role;
    }

    public function updateRole($Id, $request) {
        $role = Role::findById($Id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return $role;
    }
} 
