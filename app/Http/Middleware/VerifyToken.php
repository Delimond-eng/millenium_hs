<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['errors' => 'Token manquant']);
        }

        if (!Auth::onceUsingId($token)) {
            return response()->json(['errors' => 'Token invalide']);
        }
        return $next($request);
    }
}
