<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OperationLogRepository;
/**
* record logs
*/
class RecordLogs
{
	/**
     * @var App\Repositories\LogRepository
     */
    protected $logRepository;

	
	function __construct(OperationLogRepository $logRepository)
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
        
        $user = Auth::guard()->user();

    	$log = [
            'controller'  => $class,
            'action'      => $action,
            'querystring' => empty($request->route()->parameters()) ? '' : json_encode($request->route()->parameters()),
            'username'    => empty($user) ? '' : $user->email,
            'ip'          => $request->ip(),
    	];
    	
    	$this->logRepository->store($log);

        return $next($request);
    }
}

