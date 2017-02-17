<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Requests;

class MenuController extends Controller
{
    public $menu;

    public function __construct(Application $app)
    {
        $this->menu = $app->menu;
    }

    public function menu()
    {

        $buttons = [
            [
                "type" => "view",
                "name" => "日新首页",
                "url"  => "http://www.ecjtu.net/"
            ],
            [
                "type" => "click",
                "name" => "绑定学号",
                "key"  => "Bound"
            ],
            [
                "name"       => "服务平台",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "查课表",
                        "key" => "Score"
                    ],
                    [
                        "type" => "click",
                        "name" => "查成绩",
                        "key" => "Class"
                    ],
                    [
                        "type" => "click",
                        "name" => "考试安排",
                        "key" => "Exam"
                    ],
                ],
            ],
        ];
        $this->menu->add($buttons);
    }

    public function all()
    {
        return $this->menu->current();
    }
}
