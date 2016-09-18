<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $wechat;

    /**
     * UserController constructor.
     * @param $wechat
     */
    public function __construct(Application $wechat)
    {
        $this->wechat = $wechat;
    }

    public function getAllUsers()
    {
        $users[0] = $this->wechat->user->lists();
        $count = ceil((int)$users[0]['total'] / 10000);
        for($i = 1; $i <= $count; $i++)
        {
            $data = $this->wechat->user->lists($users[$i-1]['next_openid']);
            if ($data->count)
            {
                $users[$i] = $data;
            }
        }
        return $users;
    }

    public function getUserDetails($openId)
    {
        $user = $this->wechat->user->get($openId);
        return $user;
    }
}
