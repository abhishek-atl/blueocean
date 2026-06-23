<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Booking;
use App\Models\User;
use App\Models\UserVerify;
use App\Services\BookingMailService;
use App\Services\DatabaseService;
use App\Services\MailService;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    protected MailService $mailService;
    protected DatabaseService $databaseService;
    protected BookingMailService $bookingMailService;
    protected UserService $userService;

    public function __construct(
        MailService $mailService,
        DatabaseService $databaseService,
        BookingMailService $bookingMailService,
        UserService $userService,
    ) {
        $this->mailService = $mailService;
        $this->databaseService = $databaseService;
        $this->bookingMailService = $bookingMailService;
        $this->userService = $userService;
    }


    public function showRegisterForm(Request $request)
    {
        return view('frontend.modules.auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $firstName = null;
        $lastName = null;
        $nameParts = explode(' ', $request->name);
        $firstName = $nameParts[0];
        if (isset($nameParts[1])) {
            $lastName = $nameParts[1];
        }

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'active' => 1
        ]);
        $user->assignRole('Customer');

        $this->userService->sendVerificationLink($user->id);

        // registerd from success page
        if ($request->bookingId) {

            $booking = $this->databaseService->getByParams(Booking::class, ['id' => $request->bookingId]);
            $booking->user_id = $user->id;
            $booking->save();

            $user->mobile = $booking->phone;
            $user->postcode = $booking->postcode;
            $user->flat_no = $booking->flat_no;
            $user->street_number = $booking->street_number;
            $user->street_name = $booking->street_name;
            $user->town = $booking->town;
            $user->address = $booking->address;
            $user->save();

            // Send email if email address not supplied during booking process
            if (!$booking->email) {
                $this->bookingMailService->sendBookingMailToClient($booking, $user->email);
            }
        }
        return redirect(route('auth.login'))
            ->with('success', 'A verification link has been sent to your email address. Please check your email.')
            ->with('info', 'Please check your email to continue.');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Verification link does not exists.';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
            }
            auth()->login($user);
            $verifyUser->delete();
            $message = "Your e-mail has been verified.";
            if (session('booking'))
                return redirect()->route('bookingCheckout')->with('success', $message);
            else
                return redirect()->route('home')->with('success', $message);
        }
        return redirect()->route('auth.login')->with('error', $message);
    }

    public function sendVerificationLink($id)
    {
        $this->userService->sendVerificationLink($id);
        return redirect(route('auth.login'))->with('success', 'A verification link has been sent to your email address. Please check your email.');
    }
}
