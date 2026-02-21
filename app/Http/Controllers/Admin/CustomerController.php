<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

use App\Services\BookingService;
use App\Services\UploadService;
use App\Services\UserService;

class CustomerController extends Controller
{
    protected $uploadService;
    protected $bookingService;
    protected $userService;

    public function __construct(
        UploadService $uploadService,
        BookingService $bookingService,
        UserService $userService
    ) {
        $this->uploadService = $uploadService;
        $this->bookingService = $bookingService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');
        if (null != $request->get('search')) {
            $params['search'] = $request->get('search');
        }

        $customers = $this->userService->customers($params);
        return view('admin.modules.customer.index', [
            'customers' => $customers,
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

        return view('admin.modules.customer.create_edit', [
            'user' => $user,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $params = $request->except(['_token', 'image']);

        $params['user_type'] = 'Customer';
        $user = $this->userService->save($params);
        $this->userService->saveUserProfile($user, $params);

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.user_path');
            $path = $this->uploadService->upload($file, $uploadPath);
            $this->userService->saveUserImage($user, $path);
        }

        if (isset($params['id'])) {
            $message = 'Customer updated successfully.';
        } else {
            $message = 'Customer added successfully.';
        }

        return redirect()
            ->route('admin.customers.edit', ['id' => $user->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $user = $this->userService->find($id);
        $user->user_profile()->delete();
        $user->delete();

        return redirect()
            ->back()
            ->with('status', 'Customer deleted successfully.');
    }
}
