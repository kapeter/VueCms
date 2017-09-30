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
        10009 => ['code' => 10009, 'message' => '当前邮箱已被注册'],
        10010 => ['code' => 10010, 'message' => '非法操作'],
        10011 => ['code' => 10011, 'message' => '该角色下有用户存在，不可删除'],
        10012 => ['code' => 10012, 'message' => '未搜寻到结果'],
    ];

    public function __construct()
    {
        $this->middleware('blog.log',['except' => ['index','show']]);
        $this->middleware('cors');
    }

    /**
     * 数组 转 对象
     *
     * @param array $arr 数组
     * @return object
     */
    public function array_to_object($arr) 
    {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)$this->array_to_object($v);
            }
        }
     
        return (object)$arr;
    }
     
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    public function object_to_array($obj) 
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }
     
        return $obj;
    }

    public function reqIsFromFront($request)
    {
        return null == $request->header('authorization') ? true : false;
    }
}

