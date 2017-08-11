<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\UserTransformer;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        
        $this->userRepository = $userRepository;

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
            'name' => $request->name,
            'email' => $request->email,
            'password' => encrypt($request->pwd),
            'is_admin' => (int)$request->auth ? true : false,
            'avatar' => '/img/avatar.jpg',
            'bio' => '3123',
            'status' => false
        ];

        if ( $this->userRepository->checkUnique('email',$data['email'],0) ){
            $this->userRepository->store($data);
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
            'is_admin' => (int)$request->auth ? true : false,
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
        if($request->isMethod('post')){ 
            $id = $request->user->id;

            $data['name'] = $request->name;
            $data['bio'] = $request->bio;
            
            if (isset($request->currentPwd)){
                $credentials['email'] = $request->user->email;
                $credentials['password'] = $request->currentPwd;
                if ( JWTAuth::attempt($credentials) ){
                    $data['password'] = bcrypt($request->newPwd);
                }else{
                    return $this->response->array($this->errorMsg[10002]);
                }                
            }

            $this->userRepository->update($id,$data);

            return $this->response->noContent()->setStatusCode(200);

        }else{
            return $this->response->item($request->user, new UserTransformer);
        }        
    }    
}
