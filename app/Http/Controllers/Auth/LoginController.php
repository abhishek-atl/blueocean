<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function __construct() {}

    public function showUserLoginForm()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->hasRole(['Customer', 'Therapist'])) {
                return redirect()->route('home');
            }
        }
        return view('frontend.modules.auth.login');
    }

    public function showAdminLoginForm()
    {
        return view('admin.modules.auth.login');
    }

    public function postUserlogin(LoginRequest $request)
    {

        $throttles = 1;

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');

        if (! Auth::validate($credentials)) {
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$user->email_verified_at) {
            return back()->with('error', 'You need to verify your email. <a href="' . route('user.send_verification_link', ['id' => $user->id]) . '">Click here</a> to send verification email');
        }

        if (!$user->active) {
            return back()->with('error', 'Please contact an administrator.')->onlyInput('email');
        }

        Auth::login($user, $request->input('remember'));

        Auth::user()->update([
            'ip_address' => $request->ip(),
            'last_login_at' => now()
        ]);

        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if ($user->user_type == 'Admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if (session('booking')) {
            return redirect(route('bookingCheckout'));
        }
        if ($user->hasRole(['Therapist']) || $user->hasRole(['Customer']) ) {
            return redirect(route('bookings'));
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->input('user') === 'admin') {
            return redirect()->route('admin.login');
        }

        return redirect(route('home'));
    }
}
