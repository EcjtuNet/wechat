<?php
/**
 * Created by PhpStorm.
 * User: skycheung
 * Date: 2017/1/14
 * Time: 14:11
 */

namespace ecjtunet\schoolservice;


use Illuminate\Support\Facades\Log;

class SchoolServiceHelper
{
    public function getYearAndTerm()
    {
        date_default_timezone_set("Asia/Shanghai");
        $month = date("m");
        $year = date("Y");
        if (intval($month) >=11 && intval($month) <= 12)
        {
            $count_year = intval($year);
            $term = 1;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }
        elseif (intval($month) >=1 && intval($month) <=4)
        {
            $count_year = intval($year) - 1;
            $term = 1;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }
        else
        {
            $count_year = intval($year) - 1;
            $term = 2;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }

        return $time;
    }
}