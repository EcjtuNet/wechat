<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Jobs\queryScore;
use App\Jobs\queryClass;
use App\Jobs\queryExam;
use App\Jobs\savePassword;
//use App\Http\Controllers\CacheController;
use App\Http\Controllers\UserController;
use EasyWeChat\Message\Text;
use EasyWeChat;
use Input;
use Request;

class WechatTextController extends Controller
{
    public function __construct()
    {
        session_start();
        $this->wechat = app('wechat');
    }

    // public function distinguishText($content, $sender)
    // {
    //     switch ($this->matchContent($content)) {
    //         case "查成绩":
    //             return $this->searchScore($sender);
    //             break;
    //         case "查课表":
    //             return $this->searchClass($sender);
    //             break;
    //         case "考试安排":
    //             return $this->searchExam($sender);
    //             break;
    //         case "绑定学号":
    //             return $this->inputId($content, $sender);
    //             break;
    //         case "绑定密码":
    //             return $this->boundStudentPassword($content, $sender);
    //             break;
    //         case "确定绑定":
    //             return $this->confirmBound($sender);
    //             break;
    //         default:
    //             return 'success';
    //             break;
    //     }
    // }

    // private function matchContent($content)
    // {
    //     if (preg_match_all("/成绩/", $content))
    //     {
    //         return "查成绩";
    //     }
    //     elseif (preg_match_all("/课(程)?表/", $content))
    //     {
    //         return "查课表";
    //     }
    //     elseif (preg_match_all("/考试安排/", $content)) {
    //         return "考试安排";
    //     }
    //     elseif (preg_match_all("/bd[0-9]{14,16}/",$content))
    //     {
    //         return "绑定学号";
    //     }
    //     elseif (preg_match_all("/mm.*/",$content))
    //     {
    //         return "绑定密码";
    //     }
    //     else
    //     {
    //         return $content;
    //     }
    // }

    public function boundStudentId()
    {
        if (Request::ajax()) {
            $data = Input::all();

            $sender = $data['user_openid'];
            $number = $data['user_number'];
            $pass = $data['user_password'];
        }

        if ($number == '' && $pass == '') {
             $info = array(
                'status' => 0,
                'msg' => '请将信息填写完整' 
                );
            return $info;
        }
        elseif ($this->checkUserBound($sender))
        {
            $info = array(
                'status' => 1,
                'msg' => '你的微信号已经绑定了学号，你可以通知管理员解除绑定' 
                );
            return $info;
        }
        else
        {
            $confirmName = $this->inputId($number, $sender);
            if ($confirmName) {
                $confirmPass = $this->boundStudentPassword($number, $pass, $sender);
                if ($confirmPass) {
                   $info = array(
                    'status' => 4,
                    'msg' => "$confirmName"."绑定成功" 
                    );

                    return $info;
                }
                else
                {
                    $info = array(
                    'status' => 3,
                    'msg' => '密码错误' 
                    );

                    return $info;
                }
            }
            else
            {
                $info = array(
                    'status' => 2,
                    'msg' => '学号错误' 
                    );

                return $info;
            }
        }
    }

    private function inputId($number, $sender)
    {
        return (new CacheController())->save_studentid_with_openid($number, $sender);
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

    public function boundStudentPassword($number, $pass, $sender)
    {
        return (new SchoolServiceController())->savePassword($number, $pass, $sender);
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
