<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Api\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin_guest');
    }

    protected function broker()
    {
        return Password::broker('inspectors');
    }

    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->broker()->reset($request->validated(), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if (!$request->wantsJson()) {
            return $response == Password::PASSWORD_RESET
                ? $this->sendResetResponse($request, $response)
                : $this->sendResetFailedResponse($request, $response);
        }
        $status = $response == Password::PASSWORD_RESET;
        if ($status) {
            return response()->json(['success' => true, 'url' => route('password.changed')]);
        }
        return response()->json(['errors' => ['email' => [trans($response)]]], 422);

    }

    public function resetPasswordForm(Request $request, string $token)
    {
        return view('auth.update_password', compact('token'));
    }

    public function passwordSuccessfullyChanged()
    {
        return view('auth.password_changed');
    }
}
