<?php

namespace App\Http\Controllers;

use App\Jobs\queryScore;
use App\Jobs\testClass;
use App\Jobs\queryClass;
use App\Jobs\queryExam;
use App\Jobs\savePassword;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\UserController;
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
            case "取消绑定":
                return $this->cancelBound($sender);
                break;
            default:
                return '亲,我不明白你说了神马...';
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
        elseif (preg_match_all("/我要解绑/",$content))
        {
            return "取消绑定";
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
              $message = new Text(['content' => '已经绑定，你可以回复"我要解绑"来取消绑定']);
             EasyWeChat::staff()->message($message)->to($sender)->send();
         }
         elseif ((new UserController())->getStudentId($sender))
         {
             $message = new Text(['content' => '请回复\"mm+智慧交大登录密码\"绑定密码(例如:mm111111)']);
             EasyWeChat::staff()->message($message)->to($sender)->send();
         }
         else
         {
             $message = new Text(['content' => '请回复 "bd+学号" 进行绑定（例如：bd1111111111111111）']);
             EasyWeChat::staff()->message($message)->to($sender)->send();
         }
    }

    private function inputId($content, $sender)
    {
        if ($this->checkUserBound($sender)) {
            $message = new Text(['content' => '你已经绑定了学号，不能再绑了，但是如果你不小心绑定了别人的学号，你可以回复"我要解绑"来解除绑定']);
             EasyWeChat::staff()->message($message)->to($sender)->send();
        }else{
            $student_id = preg_replace('/bd/', '', $content);
            (new CacheController())->save_studentid_with_openid($student_id, $sender);
        }
    }

    public function cancelBound($sender)
    {
        $query = (new UserController)->deleteUser($sender);
        if ($query) {
            $message = new Text(['content' => '解绑成功，你还可以重新绑定']);
            EasyWeChat::staff()->message($message)->to($sender)->send();
        }
    }

    public function boundStudentPassword($content, $sender)
    {
        $student_id = (new CacheController())->get_studentid_by_openid($sender);
        if ($this->checkUserBound($sender)) {
            $user_info = 0;
        }else{
            $user_info = (new UserController())->addUser($sender);
        }
        if ($user_info && $student_id)
        {
            (new UserController())->boundStudentId($sender, $student_id);
            (new CacheController())->del_studentid_with_openid($sender);
        }
        $get_student_id = (new UserController())->getStudentId($sender);
        if ($get_student_id)
        {
            $pass = (new UserController)->getPass($sender);
            if ($pass) {
                $password = preg_replace('/mm/', '', $content);
                $this->dispatch(new savePassword($get_student_id, $password,$sender));
                return 'success';
            }else{
                $message = new Text(['content' => '你已经绑定成功了，不用再输入密码了']);
                EasyWeChat::staff()->message($message)->to($sender)->send();
            }
        }else{
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
            $msg = new Text(['content' => '请先完成学号绑定部分!']);

            return $this->boundStudentId($sender);

            EasyWeChat::staff()->message($message)->to($sender)->send();
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
            $msg = new Text(['content' => '请先完成学号绑定部分!']);

            return $this->boundStudentId($sender);

            EasyWeChat::staff()->message($message)->to($sender)->send();
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
            $msg = new Text(['content' => '请先完成学号绑定部分!']);

            return $this->boundStudentId($sender);

            EasyWeChat::staff()->message($message)->to($sender)->send();
        } 
    }

}
