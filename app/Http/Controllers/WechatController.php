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
        $wechat = app('wechat');
        $userApi = $wechat->user;
        $wechat->server->setMessageHandler(function($message) use ($userApi){
            switch ($message->MsgType) {
                case 'event':
                    break;
                case 'text':
                    return "欸~小新又睡觉去了，".$userApi->get($message->FromUserName)->nickname."待会就回你哈";
                    break;
                case 'image':
                    break;
                case 'voice':
                    break;
                case 'video':
                    break;
                case 'location':
                    break;
                case 'link':
                    break;
                default:
                    break;
            }
        });

        return $wechat->server->serve();
    }
}
