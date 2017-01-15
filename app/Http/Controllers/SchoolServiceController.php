<?php

namespace App\Http\Controllers;

use App\Jobs\confirmNameFail;
use App\Jobs\sendName;
use App\Jobs\sendPasswordFail;
use App\Jobs\sendPasswordSuccess;
use App\Jobs\sendScore;
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
        Log::info(serialize($info));
        if ($info)
        {
            $query = (new SchoolServiceAPI())->queryScore($info['student_id'], $info['password'], $year, $term);
            if ($query)
            {
                $this->dispatch(new sendScore($sender, $query));
            }
        }
    }
}
