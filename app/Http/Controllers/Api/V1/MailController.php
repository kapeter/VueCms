<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactMe;
use App\Http\Controllers\Api\V1\BaseController;

class MailController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sender = [
            'address' => $request->email,
            'name' => $request->name
        ];
        $subject = '来自kapeter.com的邮件 - '.$request->subject;
        $content = $request->content;

        Mail::to('121811847@qq.com')->send(new contactMe($sender, $subject, $content));

        return $this->response->array($this->errorMsg[10000]); 
    }
}
