<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenLastUsed
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->user()->currentAccessToken();

        if ($token->used_at) {
            return response()->json(['message' => 'Token expired'], 401);
        }

        $token->forceFill(['used_at' => now()])->save();

        return $next($request);

    }
}
