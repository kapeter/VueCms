<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\LogRepository;
/**
* record logs
*/
class RecordLogs
{
	/**
     * @var App\Repositories\LogRepository
     */
    protected $logRepository;

	
	function __construct(LogRepository $logRepository)
	{
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

        $token = JWTAuth::setRequest($request)->getToken();
        $user = JWTAuth::authenticate($token);

    	$log = [
            'controller'  => $class,
            'action'      => $action,
            'querystring' => empty($request->route()->parameters()) ? '' : json_encode($request->route()->parameters()),
            'username'    => empty($user) ? '' : $user->name,
            'ip'          => $request->ip(),
    	];
    	
    	$this->logRepository->store($log);

        return $next($request);
    }
}

