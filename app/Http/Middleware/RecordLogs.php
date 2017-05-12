<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Repositories\LogRepository;
/**
* record logs
*/
class RecordLogs
{
	/**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

	/**
     * @var App\Repositories\LogRepository
     */
    protected $logRepository;

	
	function __construct(LogRepository $logRepository, JWTAuth $auth)
	{
		$this->auth = $auth;
		$this->logRepository = $logRepository;
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
    	if ($request->method() == 'GET') return $next($request);

    	$route = $request->route()->getAction()['uses'];
    	list($class, $action) = explode('@', $route);

		$token = $request->session()->get('access_token');
		try {
            $user = $this->auth->authenticate($token);
        } catch(TokenExpiredException $e) {
            $newToken = $this->auth->setToken($token)->refresh();
            $request->session()->put('access_token',$newToken);

            $user = $this->auth->authenticate($newToken);
        } 

    	$log = [
            'controller'  => $class,
            'action'      => $action,
            'querystring' => empty($request->route()->parameters()) ? '' : json_encode($request->route()->parameters()),
            'username'    => $user->name,
            'ip'          => $request->ip(),
    	];
    	
    	$this->logRepository->store($log);

        return $next($request);
    }
}

