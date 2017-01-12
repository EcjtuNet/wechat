<?php

namespace App\Jobs;

use App\Http\Controllers\SchoolServiceController;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class savePassword extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student_id, $password, $openid)
    {
        $this->student_id = $student_id;
        $this->password = $password;
        $this->openid = $openid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SchoolServiceController())->savePassword($this->student_id, $this->password, $this->openid);
    }
}
