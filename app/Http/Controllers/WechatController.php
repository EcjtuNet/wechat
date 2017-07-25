<?php

namespace App\Http\Controllers;

use EasyWeChat\Message\Text;
use EasyWeChat;
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
                        $content = new Text(['content' => "/:rose欢迎关注华东交通大学，谢谢你对交大的支持！我们是你的好伙伴，将为你带来新鲜好玩的校园新闻，有用的资讯信息和贴心的生活服务！对我们有任何意见或建议都可以直接发送给我们，我们会及时给您回复！欢迎提供校园新闻线索，有什么新奇想法有趣图文也可以投稿给我们！请加入我们的17迎新群642351822/:lvu！"]);
                        EasyWeChat::staff()->message($content)->to($message->FromUserName)->send();
                    }

                    if($message->Event == 'CLICK')
                    {
                        if ($message->EventKey == 'Band') {
                            return (new WechatTextController())->boundStudentId($message->FromUserName);
                        }elseif ($message->EventKey == 'QueryScore') {
                            return (new WechatTextController())->searchScore($message->FromUserName);
                        }
                        elseif ($message->EventKey == 'QueryClass') {
                            return (new WechatTextController())->searchClass($message->FromUserName);
                        }
                        elseif ($message->EventKey == 'QueryExam') {
                            return (new WechatTextController())->searchExam($message->FromUserName);
                        }
                        elseif ($message->EventKey == 'LostAndFound') {
                            $content = new Text(['content' => "失物招领功能即将上线，届时将为大家提供平台，把丢失的饭卡速速的找回来/:8-)"]);
                            EasyWeChat::staff()->message($content)->to($message->FromUserName)->send();
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
