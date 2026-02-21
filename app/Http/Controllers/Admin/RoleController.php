<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Http\Request;

use App\Services\DatabaseService;
use App\Services\UserRoleService;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    protected UserRoleService $userRoleService;
    protected DatabaseService $databaseService;

    public function __construct(
        UserRoleService $userRoleService,
        DatabaseService $databaseService,
    ) {
        $this->userRoleService = $userRoleService;
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');
        if (null != $request->get('search')) {
            $params['like'] = ['name' => $request->get('search')];
        }

        $roles = $this->databaseService->getByParams(Role::class, $params);

        return view('admin.modules.role.index', [
            'roles' => $roles,
            'permissions' => [],
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function create()
    {
        return view('admin.modules.role.create_edit');
    }

    public function edit($id)
    {
        $role = $this->userRoleService->find($id);
        return view('admin.modules.role.create_edit', [
            'role' => $role
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();
        $role = $this->userRoleService->save($validated);

        return redirect()->route('admin.roles.edit', ['id' => $role->id])
            ->with('status', __('Role saved successfully'));
    }

    public function destroy($id)
    {
        $this->userRoleService->delete($id);
        return back()->with('status', __('Role deleted successfully'));
    }

    public function getRolePermissions($roleId)
    {
        $role = $this->userRoleService->find($roleId);
        $permissions = $this->userRoleService->groupPermissionsByModule();
        $rolePermissions = $role ? $role->permissions->pluck('name')->toArray() : [];

        return view('admin.modules.role.permissions', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ]);
    }

    public function storeRolePermissions(Request $request)
    {

        $role = $this->userRoleService->find($request->input('role_id'));

        if ($role) {
            $permissions = $request->input('permissions', []);
            $role->syncPermissions($permissions);
        }

        return redirect()->back()
            ->with('status', __('Permissions saved successfully'));
    }
}
