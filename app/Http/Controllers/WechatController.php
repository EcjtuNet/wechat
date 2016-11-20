<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\WechatTextController;

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
                    return (new WechatTextController())->distinguishText($message->Content, $message->FromUserName);
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
