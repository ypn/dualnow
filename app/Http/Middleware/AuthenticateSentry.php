<?php

namespace App\Http\Middleware;

use Closure;
use Sentry;

class AuthenticateSentry
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
        if(!Sentry::check()){            
            return redirect('./');
        }   
        //$request->attributes->add(['ypn'=>'Phamnhuy']);
        return $next($request);
    }
}
