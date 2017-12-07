<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactMe;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\MailRepository;
use App\Repositories\SettingRepository;

class MailController extends BaseController
{
    protected $mailRepository;

    protected $settingRepository;

    public function __construct(MailRepository $mailRepository, SettingRepository $settingRepository)
    {
        parent::__construct();
        
        $this->mailRepository = $mailRepository;

        $this->settingRepository = $settingRepository;

        $this->middleware('blog.api', ['except' => ['send']]);
    }

    
    /**
     * 发送邮件给管理员邮箱
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
            
            // 将发送邮件加入消息队列
            $adminEmailstr = $this->settingRepository->getByColumn('name', 'admin_email');
            if (is_array($adminEmailstr) && !is_null($adminEmailstr[0]['value'])){
                $adminEmails = explode(',', $adminEmailstr[0]['value']);
                foreach ($adminEmails as $to) {
                    Mail::to($to)->queue(new contactMe($data));  
                }                
            }

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
