<?php

namespace App\Http\Controllers;

use App\Jobs\SendClass;
use App\Jobs\SendScore;
use EasyWeChat\Message\Text;
use EasyWeChat;

class WechatTextController extends Controller
{
    public function __construct()
    {
        $this->wechat = app('wechat');
    }

    public function distinguishText($content, $sender)
    {
        switch ($this->matchContent($content)) {
            case "查成绩":
                return $this->searchScore($sender);
            case "查课表":
                return $this->searchClass($sender);
            case "绑定学号":
                return $this->boundStudentId($content, $sender);
            case "绑定密码":
                return $this->boundStudentPassword($content, $sender);
            default:
                return 'success';
        }
    }

    private function matchContent($content)
    {
        if (preg_match_all("/成绩/", $content))
        {
           return "查成绩";
        }
        elseif (preg_match_all("/课(程)?表/", $content))
        {
           return "查课表";
        }
        elseif (preg_match_all("/bd[0-9]{14,16}/",$content))
        {
            return "绑定学号";
        }
//        elseif (preg_match_all(,$content))
//        {
//            return "绑定密码";
//        }
        else
        {
            return $content;
        }
    }

    public function searchScore($sender)
    {
        if ($this->checkUserBound($sender))
        {
            $this->dispatch(new SendScore($sender));
            return "小新正在努力查找你的成绩";
        }
        else
        {
            return (new UserController())->firstMeet();
        }
    }

    public function searchClass($sender)
    {
        if ($this->checkUserBound($sender))
        {
            $this->dispatch(new SendClass($sender));
            return "小新正在努力查找你今天的课表";
        }
        else
        {
            return (new UserController())->firstMeet();
        }
    }

    public function boundStudentId($content, $sender)
    {
        if ($this->checkUserBound($sender))
        {
            $message = new Text(['content' => '已经绑定，请联系运营人员解绑']);
            EasyWeChat::staff()->message($message)->to($sender)->send();
        }
        else
        {
            $student_id = preg_replace('/bd/', '', $content);
        }
    }

    private function checkUserBound($sender)
    {
        $check = (new UserController())->checkUserBound($sender);
        if($check)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
