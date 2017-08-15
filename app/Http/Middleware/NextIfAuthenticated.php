<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class NextIfAuthenticated extends BaseMiddleware
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
        if ( !$request->session()->has('access_token') ){
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 401);
        }
        $token = $request->session()->get('access_token');

        try {
            $user = $this->auth->authenticate($token);
        } catch(TokenExpiredException $e) {
            //Token is Expired.Refresh Token
            $newToken = $this->auth->setToken($token)->refresh();
            $request->session()->put('access_token',$newToken);
            //get user from token again 
            $user = $this->auth->authenticate($newToken);
        } catch (JWTException $e) {
            $request->session()->forget('access_token');
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (! $user) {
            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
        }

        $request->user = $user;

        return $next($request);
    }
}
