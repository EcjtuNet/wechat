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
                "name" => "花椒要闻",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "花椒要闻",
                        "url" => "http://xw.ecjtu.jx.cn/1083/list.htm"
                    ],
                    [
                        "type" => "view",
                        "name" => "校园通知",
                        "url" => "http://www.ecjtu.net/html/news/rixingonggao/"
                    ]
                ]
            ],
            [
                "name" => "花椒故事",
                "sub_button" => [
                    [
                        "type" => "view_limited",
                        "name" => "美人志",
                        "media_id" => "1"
                    ],
                    [
                        "type" => "view_limited",
                        "name" => "山水交大",
                        "media_id" => "2"
                    ]
                ]
            ],
            [
                "name"       => "花椒查询",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "成绩查询",
                        "key" => "Score"
                    ],
                    [
                        "type" => "click",
                        "name" => "课表查询",
                        "key" => "Class"
                    ],
                    [
                        "type" => "click",
                        "name" => "考试查询",
                        "key" => "Exam"
                    ]
                ]
            ]
        ];
        $this->menu->add($buttons);
    }

    public function all()
    {
        return $this->menu->current();
    }
}
