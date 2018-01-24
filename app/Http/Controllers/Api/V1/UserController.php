<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\UserTransformer;
use App\Repositories\UserRepository;
use App\Repositories\PermissionRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    protected $userRepository;

    protected $permissionRepository;

    public function __construct(UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
        parent::__construct();
        
        $this->userRepository = $userRepository;

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
        $users = $this->userRepository->getUserByPaginate($request);

        return $this->response->paginator($users, new UserTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'role_id'  => $request->auth,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => encrypt($request->pwd),
            'avatar'   => '/img/avatar.jpg',
            'status'   => false
        ];

        if ( $this->userRepository->checkUnique('email',$data['email'],0) ){
            $user = $this->userRepository->store($data);
            return $this->response->noContent()->setStatusCode(200);    
        }else{
            return $this->response->array($this->errorMsg[10009]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->getById($id);

        return $this->response->item($user, new UserTransformer);
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
        $data = [
            'name' => $request->name,
            'role_id'  => $request->auth,
        ];

        if (isset($request->pwd)){
            $data['password'] = encrypt($request->pwd);
        }

        $this->userRepository->update($id,$data);
        
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
        $this->userRepository->destroy($id);

        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * show and edit the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $user = $this->getCurrentUser($request);

        $permissions = $this->permissionRepository->getPermissionByRoleId(2);  

        // 超级管理员拥有全部的权限，不需要获取
        // if ($user->role->id != 1){
        //    $permissions = $this->permissionRepository->getPermissionByRoleId(2);  
        // }else{
        //     $permissions = [];
        // }

        if($request->isMethod('post')){ 

            $data['name'] = $request->name;
            $data['bio'] = $request->bio;
            
            if (isset($request->currentPwd)){
                $credentials['email'] = $user->email;
                $credentials['password'] = $request->currentPwd;
                if ( JWTAuth::attempt($credentials) ){
                    $data['password'] = bcrypt($request->newPwd);
                }else{
                    return $this->response->array($this->errorMsg[10002]);
                }                
            }

            $user = $this->userRepository->update($user->id,$data);

        } 

        return $this->response->item($user, new UserTransformer)->addMeta('permissions', $permissions);      
    }    
}
