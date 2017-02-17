<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\WechatTextController;
use App\Http\Controllers\UserController;

class WechatController extends Controller
{
    public function serve()
    {
        $wechat = app('wechat');
        $userApi = $wechat->user;
        $wechat->server->setMessageHandler(function($message) use ($userApi) {
            switch ($message->MsgType) {
                case 'event':
                    if($message->Event == 'subscribe')
                    {
                        return '欢迎你订阅日小新公众号，在这里你可以很方便的查询自己的成绩，课表以及考试安排。请先绑定学号才能查询成绩。';
                    }

                    if($message->Event == 'CLICK')
                    {
                        if($message->EventKey == 'Bound')
                        {
                            return (new WechatTextController())->boundStudentId($message->FromUserName);
                        }
                        elseif($message->EventKey == 'Class')
                        {
                            return (new WechatTextController())->distinguishText('成绩',$message->FromUserName);
                        }
                        elseif ($message->EventKey == 'Score') 
                        {
                            return (new WechatTextController())->distinguishText('课表',$message->FromUserName);
                        }
                        elseif ($message->EventKey == 'Exam') {
                            return (new WechatTextController())->distinguishText('考试安排',$message->FromUserName);
                        }
                    }
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
