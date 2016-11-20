<?php

namespace App\Http\Controllers;

use App\Jobs\SendClass;
use App\Jobs\SendScore;
use EasyWeChat\Foundation\Application;

class WechatTextController extends Controller
{

    public function __construct()
    {
        $this->wechat = app('wechat');
    }

    public function distinguishText($content, $sender)
    {
        switch ($content) {
            case "查成绩":
                return $this->searchScore($sender);
            case "查课表":
                return $this->searchClass($sender);
        }
        return 'success';
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

    public function addUser($sender)
    {
        $query = (new UserController())->addUser($sender);
        return $query;
    }

}
