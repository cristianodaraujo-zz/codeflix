<?php

namespace App\Http\Middleware;

use App\Exceptions\SubscriptionInvalidException;
use Closure;

class CheckSubscriptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws SubscriptionInvalidException
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user('api')->hasValidSubscriptions()) {
            throw new SubscriptionInvalidException("User is not a valid subscription!");
        }

        return $next($request);
    }
}
