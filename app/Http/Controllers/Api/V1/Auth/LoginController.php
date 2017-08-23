<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends BaseController
{
    public function __construct()
    {
        
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

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->array($this->errorMsg[10003]);
            }
        } catch (Exception $e) {
            // something went wrong whilst attempting to encode the token
            return $this->response->array($this->errorMsg[10006]);
        }

        $user = JWTAuth::authenticate($token);

        $request->session()->put('user', $user);

        return $this->response->array(
            [
                'code' => 10000, 
                'message' => 'Success',
                'token' => $token
            ]
        );    
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
        $request->session()->forget('user');

        return $this->response->array($this->errorMsg[10000]);        
    }

}
