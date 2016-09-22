<?php

namespace App\Http\Controllers;

use App\Jobs\SendClass;
use App\Jobs\SendScore;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

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

    public function score($sender)
    {
        $this->dispatch(new SendScore($sender));
        return '小新正在努力查找你的成绩~~~（紧张脸）';
    }

    public function classTable($sender)
    {
        $this->dispatch(new SendClass($sender));
        return '小新正在努力查找你今天的课表！（兴奋脸）';
    }
}
