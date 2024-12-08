<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class EnsureTokenIsValid {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {
        try {
            if (!auth()->guard('api')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token is invalid or expired. Please log in again.',
                ], 401); // HTTP 401 Unauthorized
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired. Please log in again.',
                'error' => $e->getMessage(),
            ], 401); // HTTP 401 Unauthorized
        }

        return $next($request);
    }
}
