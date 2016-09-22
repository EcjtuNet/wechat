<?php

namespace App\Http\Controllers;

use DB;
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

    public function checkUser($openId)
    {
        if (DB::table('users')->where('openid', $openId)->first())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addUser($openId)
    {
        $userInfo = $this->getUserDetails($openId);
        $data = [
            'subscribe'      => $userInfo.subscribe,
            'openid'         => $userInfo.openid,
            'nickname'       => $userInfo.nickname,
            'sex'            => $userInfo.sex,
            'language'       => $userInfo.language,
            'city'           => $userInfo.city,
            'province'       => $userInfo.province,
            'country'        => $userInfo.country,
            'headimgurl'     => $userInfo.headimgurl,
            'subscribe_time' => $userInfo.subscribe_time,
            'remark'         => $userInfo.remark,
            'groupid'        => $userInfo.groupid,
            'tagid_list'     => (string)$userInfo.tagid_list,
        ];

        $query = DB::table('users')->insert($data);
        return $query;
    }

    public function boundUser($openId)
    {
       $query = DB::table('users')->where('openid', $openId)->update(['bound' => 1]);
        return $query;
    }

    public function unboundUser($openId)
    {
        $query = DB::table('users')->where('openid', $openId)->update(['bound' => 0]);
        return $query;
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

    private function getUserDetails($openId)
    {
        $user = $this->wechat->user->get($openId);
        return $user;
    }
}
