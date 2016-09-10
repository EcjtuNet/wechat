<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class WechatController extends Controller
{
    public function serve()
    {
        Log::info('request arrived.');

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 日新微信!";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }
}
