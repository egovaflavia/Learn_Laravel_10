<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIpMiddleware
{
    public $blockIps = ['whitelist-ip-1', 'whitelist-ip-2', '127.0.0.1'];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->ip(), $this->blockIps)) {
            abort(403, 'You are restricted to access the site');
        }
        return $next($request);
    }
}
