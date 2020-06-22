<?php

namespace App\Http\Middleware;

use App\Enums\CurrencyEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class SetCurrency
{
    /**
     * Check
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('currency') && in_array($request->get('currency'), CurrencyEnum::toArray())) {
            config(['app.currency' => $request->get('currency')]);
        }

        if ($request->hasHeader('x-set-currency') && in_array($request->get('currency'), CurrencyEnum::toArray())) {
            config(['app.currency', $request->header('x-set-currency')]);
        }

        return $next($request);
    }
}
