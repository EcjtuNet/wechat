<?php

namespace App\Http\Controllers;

use App\Jobs\confirmName;
use Illuminate\Http\Request;
use Redis;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CacheController extends Controller
{
    public function save_studentid_with_openid($student_id, $openid)
    {

        $cache = Redis::set("$openid:xh", $student_id);
        Redis::expire($cache, intval(env('STUDENT_ID_TIMEOUT')));
        $this->dispatch(new confirmName($student_id, $openid));
    }

    public function del_studentid_with_openid($openid)
    {
        Redis::del("$openid:xh");
    }

    public function get_studentid_by_openid($openid)
    {
        $cache = Redis::get("$openid:xh");
        return $cache;
    }
}
