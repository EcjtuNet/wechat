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
                        "type" => "view",
                        "name" => "我要投稿",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MjM5NDA2NjI0MA==&hid=1&sn=4aad9ec4644bf2b674faa222a209a79b#wechat_redirect"
                    ],
                    [   
                        "type" => "view",
                        "name" => "学在交大",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MjM5NDA2NjI0MA==&hid=1&sn=4aad9ec4644bf2b674faa222a209a79b#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "教在交大",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MjM5NDA2NjI0MA==&hid=1&sn=4aad9ec4644bf2b674faa222a209a79b#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "美人志",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MjM5NDA2NjI0MA==&hid=1&sn=4aad9ec4644bf2b674faa222a209a79b#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "山水校园",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MjM5NDA2NjI0MA==&hid=2&sn=b10cf8619f16dd72b4dcb4585b67f011#wechat_redirect"
                    ]
                ]
            ],
            [
                "name"       => "花椒查询",
                "sub_button" => [
                      [
                        "type" => "click",
                        "name" => "学号绑定",
                        "key" => "Band"
                      ],
                      [
                       "type" => "click",
                       "name" => "成绩",
                       "key" => "QueryScore"
                      ],
                      [
                       "type" => "click",
                       "name" => "课表",
                       "key" => "QueryClass"
                      ],
                      [
                       "type" => "click",
                       "name" => "考试安排",
                       "key" => "QueryExam"
                      ],
                      // [
                      //  "type" => "view",
                      //  "name" => "加入我们",
                      //  "url" => ""
                      // ],
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
