<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    protected $errorTexts = array(
        10000 => '请求成功',
        10001 => '用户未认证',
        10002 => '用户名或密码错误',
        10003 => '参数错误',
        10005 => '请求服务器失败',
    );
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //customized Response
        $errorTexts = $this->errorTexts;
        Response::macro('tokenError', function ($code,$data = null) use($errorTexts){
            if (!isset($errorTexts[$code])){
                $code = 10003;
            }
            return response()->json([
                'code' => $code, 
                'message' => $errorTexts[$code],
                'data' => $data
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
