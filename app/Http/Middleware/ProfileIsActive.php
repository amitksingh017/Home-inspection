<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $profile = Auth::user();

        if(!$profile->status){
            return response()->json(['error' => 'Your account is blocked. Please, contact admin to unblock it'], 423);
        }

        return $next($request);
    }
}
