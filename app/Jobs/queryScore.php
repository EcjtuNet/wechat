<?php

namespace App\Jobs;

use App\Http\Controllers\SchoolServiceController;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class queryScore extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SchoolServiceController())->queryScore($this->sender);
    }
}
