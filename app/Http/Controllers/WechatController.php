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
                        return '/:rose谢谢你对交大的支持！我们是你的好伙伴，将为你带来新鲜好玩的校园新闻，有用的资讯信息和贴心的生活服务/:sun！对我们有任何意见或建议都可以直接发送给我们，我们会及时给您回复！欢迎提供校园新闻线索，有什么新奇想法有趣图文也可以投稿给我们/:lvu！';
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
                        elseif ($message->EventKey == 'Query') {
                            return '/:8-) 校内查询功能即将上线';
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
