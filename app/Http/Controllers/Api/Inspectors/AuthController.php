<?php

namespace App\Http\Controllers\Api\Inspectors;

use App\Http\Requests\Api\StartLoginRequest;
use App\Models\Inspector;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     * @param StartLoginRequest $request
     * @return JsonResponse
     */
    public function login(StartLoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);
        if (isset($credentials['email'])) {
            $credentials['email'] = strtolower($credentials['email']);
        }
        if (!$token = auth('inspector')->attempt($credentials)) {
            return response()->json(['error' => 'Wrong email or password'], 401);
        }

        $profile = (new Inspector)->getByEmail($request->get('email'));

        if(!$profile->status){
            return response()->json(['error' => 'Your account is blocked. Please, contact admin to unblock it'], 423);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('inspector')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('inspector')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') . ' minutes'
        ]);
    }
}
