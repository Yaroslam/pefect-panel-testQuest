<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $stashToken = env('API_TOKEN');
        $token = $request->header('Authorization');
        if (! preg_match('/^Bearer /', $token)) {
            return response()->json(['status' => 'error', 'code' => 403, 'message' => 'Not Authenticated'], 403);
        }

        if (! preg_match("/ $stashToken/", $token)) {
            return response()->json(['status' => 'error', 'code' => 403, 'message' => 'Not Authenticated'], 403);
        }

        return $next($request);
    }
}
