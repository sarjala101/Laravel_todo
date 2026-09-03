<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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

    public function resetPassword(string $token)
    {
        return view('reset_password', [
            'token' => $token
        ]);
    }
}