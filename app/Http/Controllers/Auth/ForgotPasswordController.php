<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Services\DatabaseService;
use App\Services\MailService;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{

    protected MailService $mailService;

    protected DatabaseService $databaseService;

    public function __construct(
        MailService $mailService,
        DatabaseService $databaseService
    ) {
        $this->mailService = $mailService;
        $this->databaseService = $databaseService;
    }

    public function forgotPassword()
    {
        return view('frontend.modules.auth.forgot_password');
    }

    public function postForgotPassword(ForgotPasswordRequest $request)
    {
        $params = [];
        $params['where'] = ['email' => $request->email];
        $user = $this->databaseService->getByParams(User::class, $params)->first();
        if ($user) {
            $token = Password::getRepository()->create($user);
            $this->mailService->forgotPassword($user, $token);
            return redirect()->route('auth.login')
                ->with('success', trans('A password link will be sent to your email address if it exists in our system.'));
        } else {
            return redirect()->back()->with('success', 'A password link will be sent on your email address if it exists in our system.');
        }
    }

    public function getPasswordResetLink($token = null)
    {
        if (is_null($token) || !request('email')) {
            abort(404);
        }
        return view('frontend.modules.auth.reset')->with([
            'token' => $token,
            'email' => urldecode(request('email')),
        ]);
    }

    public function postPasswordResetLink(PasswordResetRequest $request)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect()->route('auth.login')->with('success', trans('Password has been reset successfully. Login with your new password.'));

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();

        $this->mailService->adminPasswordChanged($user);
    }
}
