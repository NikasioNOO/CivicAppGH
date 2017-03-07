<?php

namespace CivicApp\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $mode)
    {

        if(!Auth::guard($mode)->check())
        {
            if($request->ajax())
            {
                return response('Unauthorized',401);
            }
            else {
                return redirect()->route('authApp.login')
                    ->with('status', 'succes')
                    ->with('message', 'Please login');
            }
        }

        if (Auth::guard($mode)->guest() || !Auth::guard($mode)->user()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                if($mode=='webadmin')
                    return redirect()->guest('/AdminLogin');
                else
                    return redirect()->guest('/');
            }
        }

        return $next($request);
    }
}
