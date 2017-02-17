<?php

namespace App\Http\Controllers;

use App\Jobs\queryScore;
use App\Jobs\queryClass;
use App\Jobs\queryExam;
use App\Jobs\savePassword;
use EasyWeChat\Message\Text;
use EasyWeChat;
use Log;

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
                break;
            case "查课表":
                return $this->searchClass($sender);
                break;
            case "考试安排":
                return $this->searchExam($sender);
                break;
            case "绑定学号":
                return $this->inputId($content, $sender);
                break;
            case "绑定密码":
                return $this->boundStudentPassword($content, $sender);
                break;
            case "确定绑定":
                return $this->confirmBound($sender);
                break;
            default:
                return '亲，你可以输入“成绩”查询自己的成绩，输入“课表”查询你的课表,或点击菜单栏中的服务平台查询.';
                break;
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
        elseif (preg_match_all("/考试安排/", $content)) {
            return "考试安排";
        }
        elseif (preg_match_all("/bd[0-9]{14,16}/",$content))
        {
            return "绑定学号";
        }
        elseif (preg_match_all("/mm.*/",$content))
        {
            return "绑定密码";
        }
        else
        {
            return $content;
        }
    }

    public function boundStudentId($sender)
    {
        if ($this->checkUserBound($sender))
        {
            $message = new Text(['content' => '已经绑定，请联系运营人员解绑']);
            EasyWeChat::staff()->message($message)->to($sender)->send();
        }
        elseif ((new UserController())->getStudentId($sender))
        {
            $message = new Text(['content' => '请回复\"mm+智慧交大登录密码\"绑定密码(不用双引号和加号)']);
            EasyWeChat::staff()->message($message)->to($sender)->send();
        }
        else
        {
            $message = new Text(['content' => '请回复 \"bd+学号\" 进行绑定（不用双引号和加号）']);
            EasyWeChat::staff()->message($message)->to($sender)->send();
        }
    }

    public function inputId($content, $sender)
    {
        $student_id = preg_replace('/bd/', '', $content);
            (new CacheController())->save_studentid_with_openid($student_id, $sender);
            return "success";
    }

    public function confirmBound($sender)
    {
        $student_id = (new CacheController())->get_studentid_by_openid($sender);
        $user_info = (new UserController())->addUser($sender);
        if ($user_info && $student_id)
        {
            (new UserController())->boundStudentId($sender, $student_id);
            (new CacheController())->del_studentid_with_openid($sender);
            return "请回复\"mm+智慧交大登录密码\"绑定密码(不用双引号和加号)";
        }
        return "诶呀，好像出了点问题，稍后再试试吧";
    }

    public function boundStudentPassword($content, $sender)
    {
        $student_id = (new UserController())->getStudentId($sender);
        if ($student_id)
        {
            $password = preg_replace('/mm/', '', $content);
            $this->dispatch(new savePassword($student_id, $password,$sender));
            return 'success';
        }
        else
        {
            return "请先绑定学号";
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

    public function searchScore($sender)
    {
        if ($this->checkUserBound($sender))
        {
            $this->dispatch(new queryScore($sender));
            return "小新正在努力查找你的成绩";
        }
        else
        {
            return $this->boundStudentId($sender);
        }
    }

    public function searchClass($sender)
    {
        if ($this->checkUserBound($sender))
        {
            $this->dispatch(new queryClass($sender));
            return "小新正在努力查找你今天的课表";
        }
        else
        {
            return $this->boundStudentId($sender);
        }
    }

    public function searchExam($sender)
    {
       if ($this->checkUserBound($sender))
        {
            $this->dispatch(new queryExam($sender));
            return "小新正在努力查找你的考试安排";
        }
        else
        {
            return $this->boundStudentId($sender);
        } 
    }

}
