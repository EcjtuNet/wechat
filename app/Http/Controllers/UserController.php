<?php

namespace App\Http\Controllers;

use DB;
use EasyWeChat\Foundation\Application;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param $wechat
     */
    public function __construct()
    {
        $this->wechat = app('wechat');
    }

    public function firstMeet()
    {
        return "嗨!请回复 \"bd学号\" 进行绑定（不用双引号）";
    }

    public function addUser($openId)
    {
        $userInfo = $this->getUserDetails($openId);
        $data = [
            'subscribe'      => $userInfo['subscribe'],
            'openid'         => $userInfo['openid'],
            'nickname'       => $userInfo['nickname'],
            'sex'            => $userInfo['sex'],
            'language'       => $userInfo['language'],
            'city'           => $userInfo['city'],
            'province'       => $userInfo['province'],
            'country'        => $userInfo['country'],
            'headimgurl'     => $userInfo['headimgurl'],
            'subscribe_time' => $userInfo['subscribe_time'],
            'remark'         => $userInfo['remark'],
            'groupid'        => $userInfo['groupid'],
            'tagid_list'     =>  serialize($userInfo['tagid_list']),
        ];

        $query = DB::table('users')->insert($data);
        return $query;
    }

    private function getUserDetails($openId)
    {
        $user = $this->wechat->user->get($openId);
        return $user;
    }

    public function checkUserBound($openId)
    {
        if (DB::table('users')->where('openid', $openId)->first()['bound'])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function boundStudentId($openId, $student_id)
    {
        $data = [
            'student_id' => $student_id
        ];
        $query = DB::table('users')->where('openid', $openId)->update($data);
        return $query;
    }

    public function boundStudentPassword($openId, $password)
    {
        $data = [
            'password' => $password,
            'bound' => True
        ];
        $query = DB::table('users')->where('openid', $openId)->update($data);
        return $query;
    }

    public function unboundUser($openId)
    {
        $query = DB::table('users')->where('openid', $openId)->update(['bound' => 0]);
        return $query;
    }

//    public function getAllUsers()
//    {
//        $users[0] = $this->wechat->user->lists();
//        $count = ceil((int)$users[0]['total'] / 10000);
//        for($i = 1; $i <= $count; $i++)
//        {
//            $data = $this->wechat->user->lists($users[$i-1]['next_openid']);
//            if ($data->count)
//            {
//                $users[$i] = $data;
//            }
//        }
//        return $users;
//    }
}
