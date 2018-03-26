<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserLogRepository;

class AuthController extends BaseController
{
    protected $logRepository;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserLogRepository $logRepository)
    {
        $this->middleware('blog:api', ['except' => ['login']]);

        $this->logRepository = $logRepository;
    }
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);
        // grab credentials from the request
        $credentials = $request->only('email', 'password');  

        if ($token = $this->guard()->attempt($credentials)) {

            $user = $this->me();
            $data = [
                'username' => $user->name,
                'email'    => $user->email,
                'ip'       => $request->ip(),
            ];
            $this->logRepository->store($data);

            return $this->respondWithToken($token);
        }else{
            return $this->response->array($this->errorMsg[10003]);
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required', 
            'password' => 'required',
        ]);
    }

    /**
     * Handle a logout request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        return $this->response->array($this->errorMsg[10000]);        
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }


    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->guard()->user();
    }
}
