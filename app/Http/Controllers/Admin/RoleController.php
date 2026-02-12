<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Repositories\User\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->getAllRoles();

        return view(
            'admin.modules.role.index',
            [
                'roles' => $roles,
                'permissions' => [],
                'title' => 'Roles',
            ]
        );
    }

    public function create()
    {
        return view('admin.modules.role.addUpdate');
    }

    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        return view('admin.modules.role.addUpdate', ['role' => $role]);
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();
        $this->roleRepository->save($validated);

        if (isset($validated['id'])) {
            return redirect()->route('admin.modules.role.index')
                ->with('status', __('Updated Successfully'));
        }

        return redirect()->route('admin.modules.role.index')
            ->with('status', __('Created Successfully'));
    }

    public function destroy($id)
    {
        $this->roleRepository->delete($id);
        return back()->with('status', __('Deleted Successfully'));
    }

    public function getRolePermissions($roleId)
    {
        $role = $this->roleRepository->find($roleId);
        $permissions = $this->roleRepository->groupPermissionsByModule();
        $rolePermissions = $role ? $role->permissions->pluck('name')->toArray() : [];

        return view('admin.modules.role.permissions', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ]);
    }

    public function storeRolePermissions(Request $request)
    {

        $role = $this->roleRepository->find($request->input('role_id'));

        if ($role) {
            $permissions = $request->input('permissions', []);
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.modules.role.index')
            ->with('status', __('Permissions Updated Successfully'));
    }
}
