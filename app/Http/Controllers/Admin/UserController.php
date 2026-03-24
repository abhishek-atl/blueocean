<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

use App\Services\BookingService;
use App\Services\DatabaseService;
use App\Services\UploadService;
use App\Services\UserService;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $uploadService;
    protected $bookingService;
    protected $userService;
    protected $databaseService;

    public function __construct(
        UploadService $uploadService,
        BookingService $bookingService,
        UserService $userService,
        DatabaseService $databaseService
    ) {
        $this->uploadService = $uploadService;
        $this->bookingService = $bookingService;
        $this->userService = $userService;
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');
        if (null != $request->get('search')) {
            $params['search'] = $request->get('search');
        }

        $users = $this->userService->admins($params);
        $users->load('roles');
        return view('admin.modules.user.index', [
            'users' => $users,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $user = null;
        if ($id) {
            $user = $this->userService->find($id);
            $user->load(['user_profile']);
        }

        $roles = $this->databaseService->getByParams(Role::class, ['where' => ['is_default' => 0]]);

        return view('admin.modules.user.create_edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->get('id'),
            'password' => $request->get('id') ? 'nullable|string|min:6' : 'required|string|min:6',
            'active' => 'required|boolean',
            'role' => 'required|string|exists:roles,name',
        ]);

        $params['user_type'] = 'Admin';
        $user = $this->userService->save($params);
        $user->assignRole($params['role']);

        if (isset($params['id'])) {
            $message = 'Admin updated successfully.';
        } else {
            $message = 'Admin added successfully.';
        }

        return redirect()
            ->route('admin.users.edit', ['id' => $user->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $user = $this->userService->find($id);
        $user->delete();

        return redirect()
            ->back()
            ->with('status', 'Admin deleted successfully.');
    }
}
