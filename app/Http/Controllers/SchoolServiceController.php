<?php

namespace App\Http\Controllers;

use App\Jobs\apiQueryFail;
use App\Jobs\confirmNameFail;
use App\Jobs\sendName;
use App\Jobs\sendPasswordFail;
use App\Jobs\sendPasswordSuccess;
use App\Jobs\sendScore;
use App\Jobs\sendScoreFail;
use App\Jobs\sendClass;
use App\Jobs\sendClassFail;
use App\Jobs\sendExam;
use App\Jobs\sendExamFail; 
use ecjtunet\schoolservice\SchoolServiceHelper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use ecjtunet\schoolservice\SchoolServiceAPI;
use Log;

class SchoolServiceController extends Controller
{
    public function confirmName($student_id, $sender)
    {
        $query = (new SchoolServiceAPI())->confirmName($student_id);
        if ($query)
        {
            $this->dispatch(new sendName($query, $sender));
        }
        else
        {
            (new CacheController())->del_studentid_with_openid($sender);
            $this->dispatch(new confirmNameFail($sender));
        }
    }

    public function savePassword($student_id, $password, $sender)
    {
        $query = (new SchoolServiceAPI())->savePassword($student_id, $password);
        if ($query)
        {
            (new UserController())->boundStudentPassword($sender, $password);
            $this->dispatch(new sendPasswordSuccess($sender));
        }
        else
        {
            $this->dispatch(new sendPasswordFail($sender));
        }
    }

    public function queryScore($sender)
    {
        $info = (new UserController())->getStudentIdAndPassword($sender);
        $time = (new SchoolServiceHelper())->getYearAndTerm();
        $year = $time['year'];
        $term = $time['term'];
        if ($info)
        {
            $query = (new SchoolServiceAPI())->queryScore($info['student_id'], $info['password'], $year, $term);
            if ($query['code'] == 200)
            {
                if ($query['data'])
                {
                    $this->dispatch(new sendScore($sender, $query));
                }
                else
                {
                    $this->dispatch(new sendScoreFail($sender));
                }
            }
            else
            {
                if ($query['code'] == 400)
                {
                    Log::error("400: score api query failed");
                }
                elseif ($query['code'] == 500)
                {
                    Log::error("500: score api query failed");
                }
                else
                {
                    Log::error("socre query function something failed");
                }
                $this->dispatch(new apiQueryFail($sender));
            }
        }
    }

    public function queryClass($sender)
    {
        $info = (new UserController())->getStudentIdAndPassword($sender);
        $time = (new SchoolServiceHelper())->getYearAndTerm();
        $year = $time['year'];
        $term = $time['term'];
        if ($info)
        {
            $query = (new SchoolServiceAPI())->queryClass($info['student_id'], $info['password'], $year, $term);
            if ($query['code'] == 200)
            {
                //Log::debug("queryok");
                if ($query)
                {
                    $this->dispatch(new sendClass($sender,$query));
                }
                else
                {
                    $this->dispatch(new sendClassFail($sender));
                }
            }
            else
            {
                if ($query['code'] == 400)
                {
                    Log::error("400: score api query failed");
                }
                elseif ($query['code'] == 500)
                {
                    Log::error("500: score api query failed");
                }
                else
                {
                    Log::error("socre query function something failed");
                }
                $this->dispatch(new apiQueryFail($sender));
            }
        }
    }

    public function queryExam($sender)
    {
        $info = (new UserController())->getStudentIdAndPassword($sender);
        $time = (new SchoolServiceHelper())->getYearAndTerm();
        $year = $time['year'];
        $term = $time['term'];
        if ($info)
        {
            $query = (new SchoolServiceAPI())->queryExam($info['student_id'], $info['password'], $year, $term);
            if ($query['code'] == 200)
            {
                if ($query)
                {
                    $this->dispatch(new sendExam($sender,$query));
                }
                else
                {
                    $this->dispatch(new sendExamFail($sender));
                }
            }
            else
            {
                if ($query['code'] == 400)
                {
                    Log::error("400: score api query failed");
                }
                elseif ($query['code'] == 500)
                {
                    Log::error("500: score api query failed");
                }
                else
                {
                    Log::error("socre query function something failed");
                }
                $this->dispatch(new apiQueryFail($sender));
            }
        }
    }
}
