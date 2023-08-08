<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 03.01.2020
 */

namespace Appus\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Appus\Admin\Http\Controllers\Auth\Traits\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $response = $this->broker()
            ->sendResetLink($this->credentials($request));
        $success = $response == Password::RESET_LINK_SENT;

        if (!$request->wantsJson()) {
            return $success
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
        }

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => trans($response)
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'email' => [
                    trans($response)
                ]
            ]
        ], 422);


    }

}
