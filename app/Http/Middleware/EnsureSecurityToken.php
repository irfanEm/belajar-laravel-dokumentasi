<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSecurityToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-SECURITY-TOKEN');
        if($token !== 'irfan-em97') {
            return response()->json([
                "message" => "Akses ditolak, token tidak valid !."
            ], 403);
        }
        return $next($request);
    }
}
