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
        $this->userRepository = $userRepository;

        $this->middleware('blog.api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
                    return response()->json(['status'=>400,'message' => '当前密码错误！']);
                }                
            }

            $this->userRepository->update($id,$data);

            return $this->response->noContent()->setStatusCode(200);

        }else{
            return $this->response->item($request->user, new UserTransformer);
        }        
    }    
}
