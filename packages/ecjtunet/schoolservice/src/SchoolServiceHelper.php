<?php
/**
 * Created by PhpStorm.
 * User: skycheung
 * Date: 2017/1/14
 * Time: 14:11
 */

namespace ecjtunet\schoolservice;


use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class SchoolServiceHelper
{
    public function getYearAndTerm()
    {
        date_default_timezone_set("Asia/Shanghai");
        $month = date("m");
        Logger::INFO($month);
        Logger::INFO(gettype($month));
    }
}