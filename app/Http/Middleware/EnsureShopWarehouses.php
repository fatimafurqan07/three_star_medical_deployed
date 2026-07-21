<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Warehouse;

class EnsureShopWarehouses
{
    /**
     * Ensure every branch has a corresponding shop warehouse record.
     * Runs once per authenticated web request (idempotent – uses firstOrCreate).
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only run once per session to avoid hitting DB on every request
        if (auth()->check() && ! $request->session()->get('shops_ensured')) {
            Warehouse::ensureShopWarehousesExists();
            $request->session()->put('shops_ensured', true);
        }

        return $next($request);
    }
}
