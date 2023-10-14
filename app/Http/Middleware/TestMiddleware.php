<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class TestMiddleware {
    public function handle (Request $request, Closure $next) {
        echo 'Test Middleware';
        return $next($request);
    }
}