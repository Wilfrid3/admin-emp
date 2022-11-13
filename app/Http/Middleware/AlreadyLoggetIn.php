<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AlreadyLoggetIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session()->has('accountid') && (url('/') == $request->url() || url('signup_sa') == $request->url())){
            return back();
        }
        return $next($request);
    }
}
