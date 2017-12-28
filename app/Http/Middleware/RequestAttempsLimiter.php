<?php

namespace App\Http\Middleware;

use Illuminate\Cache\RateLimiter;

//Facades
use Closure;
use Redirect;

class RequestAttempsLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $field, $max_attemps, $time_window)
    {
        $limiter = app(RateLimiter::class);

        if ($limiter->tooManyAttempts(
            $this->getKey($request,$field),
            $max_attemps,
            $time_window

        )) {
            return Redirect::back()->with('max_request_attemps_exceeded', true);
        }

        else {
            $limiter->hit(
                $this->getKey($request, $field),
                $time_window
            );
        }

        return $next($request);
    }

    protected function getKey($request, $field)
    {

        return 'request-attemps-limiter---' . $request->path() . '-' . $request->input($field) . '-' . $request->ip();
    }
}
