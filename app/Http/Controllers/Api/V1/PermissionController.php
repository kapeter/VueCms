<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\PermissionRepository;
use App\Transformers\PermissionTransformer;

class PermissionController extends BaseController
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        parent::__construct();
        
        $this->permissionRepository = $permissionRepository;

        $this->middleware('blog.api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionRepository->all();

        return $this->response->collection($permissions, new PermissionTransformer);
    }
}
