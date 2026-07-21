<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TherapistApplication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TherapistApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = in_array($request->get('sort_by'), ['id', 'first_name', 'last_name', 'email', 'approved', 'created_at'], true)
            ? $request->get('sort_by')
            : 'created_at';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';

        $applications = TherapistApplication::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->get('search');
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('mobile', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($request->get('status'), ['pending', 'approved'], true), function ($query) use ($request) {
                $query->where('approved', $request->get('status') === 'approved');
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(config('custom.db.per_page'))
            ->withQueryString();

        return view('admin.modules.therapist_application.index', [
            'applications' => $applications,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);
    }

    public function approve($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {
            $application = TherapistApplication::query()->lockForUpdate()->findOrFail($id);

            if ($application->approved) {
                throw ValidationException::withMessages([
                    'application' => 'This application has already been approved.',
                ]);
            }

            if (User::where('email', $application->email)->exists()) {
                throw ValidationException::withMessages([
                    'application' => 'A user with this email address already exists.',
                ]);
            }

            $user = User::create([
                'first_name' => $application->first_name,
                'last_name' => $application->last_name,
                'email' => $application->email,
                'email_verified_at' => now(),
                'password' => Hash::make('blueOcean10'),
                'user_type' => User::TYPE_THERAPIST,
                'ip_address' => $application->ip_address,
                'active' => true,
            ]);

            $user->user_profile()->create([
                'mobile' => $application->mobile,
            ]);
            $user->assignRole(User::TYPE_THERAPIST);

            $application->update([
                'approved' => true,
            ]);
        });

        return redirect()
            ->route('admin.therapist_applications.index')
            ->with('status', 'Therapist application approved successfully.');
    }
}
