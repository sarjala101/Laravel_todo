<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

            class ForgetPasswordManager extends Controller
{
    public function forgetPassword()
    {
        return view('forget_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'success',
                'Password reset link sent successfully!'
            );
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    public function resetPassword(Request $request, string $token)
    {
    return view('reset_password', [
        'token' => $token,
        'email' => $request->email
    ]);
    }
    public function updatePassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ),
        function ($user, $password) {

            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {

        return redirect()
            ->route('login')
            ->with('success', 'Password reset successfully! You can now login.');
    }

    return back()->withErrors([
        'email' => [__($status)],
    ]);
}
}