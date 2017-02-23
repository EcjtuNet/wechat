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
    public function getYearAndTermForScore()
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

    public function getYearAndTermForClass()
    {
        date_default_timezone_set("Asia/Shanghai");
        $month = date("m");
        $year = date("Y");
        if(intval($month) >= 2 && intval($month) <= 7)
        {
            $count_year = intval($year) - 1;
            $term = 2;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        } 
        elseif(intval($month) >= 8  && intval($month) <= 12)
        {
            $count_year = intval($year);
            $term = 1;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }
        elseif (intval($month) == 1) {
            $count_year = intval($year);
            $term = 2;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }

        return $time;
    }

    public function getYearAndTermForExam()
    {
        date_default_timezone_set("Asia/Shanghai");
        $month = date("m");
        $year = date("Y");
        if(intval($month) >= 2 && intval($month) <= 7)
        {
            $count_year = intval($year) - 1;
            $term = 2;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        } 
        elseif(intval($month) >= 8  && intval($month) <= 12)
        {
            $count_year = intval($year);
            $term = 1;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }
        elseif (intval($month) == 1) {
            $count_year = intval($year);
            $term = 1;
            $time = [
                'year' => $count_year,
                'term' => $term
            ];
        }

        return $time;
    }
}
