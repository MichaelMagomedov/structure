<?php

namespace App\Module\Test\Middleware;

use Closure;

class TestMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}