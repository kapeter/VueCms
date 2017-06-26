<?php

namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    use Helpers;
    
    /**
     * 错误信息代码
     * @var array
     */
    public $errorMsg = [
    	10000 => ['code' => 10000, 'message' => 'Success'],
    	10001 => ['code' => 10001, 'message' => '唯一标识重复'],
    	10002 => ['code' => 10002, 'message' => '当前密码错误'],
    	10003 => ['code' => 10003, 'message' => '用户名或密码错误'],
    	10004 => ['code' => 10004, 'message' => '参数错误'],
    	10005 => ['code' => 10005, 'message' => 'token未提供'],
    	10006 => ['code' => 10006, 'message' => '请求服务器失败'],
        10007 => ['code' => 10007, 'message' => '非法的文件类型'],
        10008 => ['code' => 10008, 'message' => '文件不存在'],
    ];

    public function __construct()
    {
        $this->middleware('blog.log',['except' => ['index','show']]);
    }
}

