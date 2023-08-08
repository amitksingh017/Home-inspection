<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 03.01.2020
 */

namespace Appus\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Appus\Admin\Http\Controllers\Auth\Traits\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin_guest');
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('dashboard');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin::auth.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $response = $this->broker()->reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });
        if (!$request->wantsJson()) {
            return $response == Password::PASSWORD_RESET
                ? $this->sendResetResponse($request, $response)
                : $this->sendResetFailedResponse($request, $response);
        }
        $status = $response == Password::PASSWORD_RESET ? true : false;
        if ($status) {
            return response()->json(['success' => true, 'url' => $this->redirectPath()]);
        }
        return response()->json(['errors' => ['email' => [trans($response)]]], 422);
    }

}
