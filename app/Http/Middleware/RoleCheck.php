<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Coba autentikasi dengan Sanctum
        if (!Auth::guard('sanctum')->check()) {
            // Cek cookie untuk token
            $token = $request->cookie('auth_token');
            
            // Cek jika token ada di header Authorization
            if (!$token && $request->bearerToken()) {
                $token = $request->bearerToken();
            }
            
            // Jika tidak ada token sama sekali, redirect ke login
            if (!$token) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Unauthenticated'], 401);
                }
                return redirect()->route('login');
            }
            
            // Set token untuk diproses oleh middleware Sanctum
            $request->headers->set('Authorization', 'Bearer ' . $token);
            
            // Coba authenticate ulang setelah menambahkan token
            if (!Auth::guard('sanctum')->check()) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Invalid token'], 401);
                }
                return redirect()->route('login');
            }
        }
        
        return $next($request);
    }
}
