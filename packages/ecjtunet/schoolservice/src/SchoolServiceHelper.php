<?php
/**
 * Created by PhpStorm.
 * User: skycheung
 * Date: 2017/1/14
 * Time: 14:11
 */

namespace ecjtunet\schoolservice;


class SchoolServiceHelper
{
    public function getYearAndTerm()
    {
        date_default_timezone_set("Asia/Shanghai");
        $month = date("m");
        \Log::info($month);
        \Log::info(gettype($month));
    }
}