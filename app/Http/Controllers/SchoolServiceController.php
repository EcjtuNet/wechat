<?php

namespace App\Http\Controllers;

use App\Jobs\confirmName;
use App\Jobs\confirmNameFail;
use App\Jobs\sendName;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use ecjtunet\schoolservice\SchoolServiceAPI;

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
}
