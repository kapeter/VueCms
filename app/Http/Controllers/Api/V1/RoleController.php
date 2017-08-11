<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\RoleRepository;
use App\Transformers\RoleTransformer;

class RoleController extends BaseController
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        parent::__construct();
        
        $this->roleRepository = $roleRepository;

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

        $roles = $this->roleRepository->paginate($per_page);

        return $this->response->paginator($roles, new RoleTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->roleRepository->destroy($id);

        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ( $this->roleRepository->checkUnique('name',$data['name']) ){
            $this->roleRepository->store($data);
            return $this->response->noContent()->setStatusCode(200);    
        }else{
            return $this->response->array($this->errorMsg[10009]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if ( $this->roleRepository->checkUnique('name',$data['name'], $id) ){
            $this->roleRepository->update($id,$data);
            return $this->response->noContent()->setStatusCode(200);    
        }else{
            return $this->response->array($this->errorMsg[10009]);
        }
    }
}
