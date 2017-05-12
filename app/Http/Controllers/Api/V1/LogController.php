<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\LogRepository;
use App\Transformers\LogTransformer;

class LogController extends BaseController
{
    protected $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        parent::__construct();
        
        $this->logRepository = $logRepository;

        $this->middleware('blog.api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$per_page = isset($request->per_page) ? $request->per_page : 10;

        $logs = $this->logRepository->paginate($per_page);

        return $this->response->paginator($logs, new LogTransformer);
    }
}
