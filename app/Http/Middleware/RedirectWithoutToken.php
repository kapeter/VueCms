<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Contracts\Routing\ResponseFactory;

class RedirectWithoutToken
{

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory  $response
     * @param \Illuminate\Contracts\Events\Dispatcher  $events
     * @param \Tymon\JWTAuth\JWTAuth  $auth
     */
    public function __construct(JWTAuth $auth)
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
    public function handle($request, Closure $next)
    {
        if ( !$request->session()->has('access_token') ){
            return redirect()->route('login');
        }else{
            $token = $request->session()->get('access_token');
        }

        if (! $user = $this->auth->authenticate($token)) {
            $request->session()->forget('access_token');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
