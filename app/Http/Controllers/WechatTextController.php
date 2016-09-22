<?php

namespace App\Http\Controllers;

use App\Jobs\SendClass;
use App\Jobs\SendScore;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class WechatTextController extends Controller
{
    public function distinguishText($content, $sender)
    {
        switch ($content) {
            case '查成绩':
                return $this->score($sender);
            case '查课表':
                return $this->classTable($sender);
        }
        return 'success';
    }

    public function checkUserExist($sender)
    {
        $wechat = app('wechat');
        $check = (new UserController($wechat))->checkUser($sender);
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
        $wechat = app('wechat');
        $query = (new UserController($wechat))->addUser($sender);
        return $query;
    }

    public function score($sender)
    {
        if ($this->checkUserExist($sender))
        {
            $this->dispatch(new SendScore($sender));
            return '小新正在努力查找你的成绩~~~（紧张脸）';
        }
        else
        {
            $this->addUser($sender);
            return '第一次见，请多指教';
        }
    }

    public function classTable($sender)
    {
        $this->dispatch(new SendClass($sender));
        return '小新正在努力查找你今天的课表！（兴奋脸）';
    }

}
