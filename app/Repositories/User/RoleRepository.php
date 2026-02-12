<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    protected $model;

    public function __construct(Role $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function groupPermissionsByModule()
    {
        $permissions = Permission::all();
        $grouped = [];

        foreach ($permissions as $permission) {
            $module = explode(' ', $permission->name)[1];
            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }
            $grouped[$module][] = $permission;
        }

        return $grouped;
    }

    public function save($data)
    {
        if (isset($data['id'])) {
            $role = Role::whereId($data['id'])->first();
            $role->update($data);
            return $role;
        } else {
            return Role::create($data);
        }
    }

    public function find($id)
    {
        return Role::whereId($id)->first();
    }

    public function delete($id)
    {
        $role = Role::whereId($id)->first();
        if ($role) {
            $role->syncPermissions([]);
            $role->delete();
            return true;
        }
        return false;
    }
}
