<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\OperationLogRepository;
use App\Transformers\OperationLogTransformer;

class OperationLogController extends BaseController
{
    protected $logRepository;

    public function __construct(OperationLogRepository $logRepository)
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
    public function index()
    {

        $logs = $this->logRepository->paginate(10);

        return $this->response->paginator($logs, new OperationLogTransformer);
    }
}
