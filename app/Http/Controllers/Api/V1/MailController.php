<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactMe;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\MailRepository;

class MailController extends BaseController
{
    protected $mailRepository;

    public function __construct(MailRepository $mailRepository)
    {
        parent::__construct();
        
        $this->mailRepository = $mailRepository;

        $this->middleware('blog.api', ['except' => ['send']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $data = array_merge($request->all(),
            [
                'user_ip' => $request->ip()
            ]
        );

        if ($this->mailRepository->checkRate($data['user_ip'])){
            //Mail::to('121811847@qq.com')->send(new contactMe($data));

            foreach ($data as $value) {
                $value = htmlentities($value, ENT_QUOTES, 'UTF-8');
            }
            $this->mailRepository->store($data);

            return $this->response->array($this->errorMsg[10000]);             
        }else{
            return $this->response->array($this->errorMsg[10014]);    
        }

    }
}
