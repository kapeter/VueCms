<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\UserLogRepository;
use App\Transformers\UserLogTransformer;

class UserLogController extends BaseController
{
    protected $logRepository;

    public function __construct(UserLogRepository $logRepository)
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

        return $this->response->paginator($logs, new UserLogTransformer);
    }
}
