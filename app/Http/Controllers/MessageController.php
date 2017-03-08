<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat;
use EasyWeChat\Foundation\Application;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->wechat = app('wechat');
    }

    public function getNews()
    {
        $material = $this->wechat->material;
        $lists = $material->lists('news', 0, 1);
        return $lists;
    }
}
