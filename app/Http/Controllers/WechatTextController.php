<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WechatTextController extends Controller
{

    /**
     * WechatTextController constructor.
     */
    public function __construct(Application $wechat)
    {
        $this->wechat = $wechat;
    }

    public function distinguishText(Text $message)
    {
        return $message;
    }
}
