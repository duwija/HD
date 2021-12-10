<?php

namespace App\Http\Middleware;

use Closure;

class XenditAuth
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


    if($request->header("X-CALLBACK-TOKEN") == env('XENDIT_CALLBACK_KEY'))
{
        return $next($request);
    }
    else{
        return response()->json(['error_code' => 403, 'message' => 'API Key is required']);
    }


    }
}
