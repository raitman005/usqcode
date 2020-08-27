<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user->hasRole('agent')) {
            return response('Unauthorized.', 401);         
        }

        return $next($request);
    }
}
