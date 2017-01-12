<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Http\Controllers\SchoolServiceController;

class confirmName extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student_id, $openid)
    {
        $this->student_id = $student_id;
        $this->openid = $openid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SchoolServiceController())->confirmName($this->student_id, $this->openid);
    }
}
