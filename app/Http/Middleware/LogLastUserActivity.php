<?php

namespace App\Http\Middleware;

use Closure;
use Sentry;
use Carbon\Carbon;
use Cache;

use App\Entities\Users;

class LogLastUserActivity
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
        if(Sentry::check()){
           // $expiresAt = Carbon::now()->addMinutes(10);//Neu user khon request trong 10 phut => offline

            Users::where('id',Sentry::getUser()->id)->update(['last_action'=>Carbon::now()]);

            //Cache::put('user-is-online-' . Sentry::getUser()->id, true, $expiresAt);
        }
       
        return $next($request);
    }
}
