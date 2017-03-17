<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

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
        }

        $token = $request->session()->get('access_token');
        try {
            $user = $this->auth->authenticate($token);
        } catch(TokenExpiredException $e) {
            $newToken = $this->auth->setToken($token)->refresh();
            $request->session()->put('access_token',$newToken);
        } catch (JWTException $e) {
            $request->session()->forget('access_token');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
