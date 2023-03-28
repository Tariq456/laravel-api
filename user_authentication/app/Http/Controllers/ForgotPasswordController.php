<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
    $this->validateEmail($request);

    $response = $this->broker()->sendResetLink(
        $this->credentials($request)
    );

    return $response == Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Password reset link sent to your email'], 200)
                : response()->json(['message' => 'Unable to send reset link'], 422);
    }

    protected function broker()
    {
        return Password::broker();
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }
}
