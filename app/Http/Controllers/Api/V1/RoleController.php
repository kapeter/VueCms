<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use App\Transformers\RoleTransformer;

class RoleController extends BaseController
{
    protected $roleRepository;

    protected $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        parent::__construct();
        
        $this->roleRepository = $roleRepository;
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
        $per_page = 100;

        $roles = $this->roleRepository->paginate($per_page);

        return $this->response->paginator($roles, new RoleTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_merge($request->all(),
            [
            	'is_admin' => false
            ]
        );

        if ( $this->roleRepository->checkUnique('name',$data['name']) ){
            $role = $this->roleRepository->store($data);
            // 初始化权限
            $permission = $this->permissionRepository->all();

            $this->roleRepository->setPermission($role->id, $permission);

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
    	//禁止修改管理员信息
    	$role = $this->roleRepository->getById($id);

    	if ($role->is_admin) {
    		return $this->response->array($this->errorMsg[10010]);
    	}

        $data = $request->all();
        //禁止其他角色成为管理员
        $data['is_admin'] = false;  

        if ( $this->roleRepository->checkUnique('name',$data['name'], $id) ){
            $this->roleRepository->update($id,$data);
            return $this->response->noContent()->setStatusCode(200);    
        }else{
            return $this->response->array($this->errorMsg[10009]);
        }
    }

    /**
     * show the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = $this->permissionRepository->all();
        $permissions = $this->roleRepository->getPermission($id,$list);
        foreach ($permissions as $item){
            $permission_info = $this->permissionRepository->getById($item->permission_id);
            $item->title = $permission_info->title;
            $item->name = $permission_info->route;
            $item->icon = $permission_info->icon;
        }
        return $this->response->array($permissions);
    }

    /**
     * build the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function build(Request $request, $id)
    {
        $data = [];

        foreach ($request->all() as $item) {
            array_push($data, $this->array_to_object($item));
        }

        $this->roleRepository->setPermission($id, $data);

        return $this->response->noContent()->setStatusCode(200);    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->roleRepository->hasUser($id)){

            return $this->response->array($this->errorMsg[10011]); 

        }else{
            $this->roleRepository->destroy($id);

            $this->roleRepository->delRelate($id);  

            return $this->response->noContent()->setStatusCode(200);      
        } 
    }
}
