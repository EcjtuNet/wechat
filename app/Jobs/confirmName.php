<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Http\Controllers\SchoolServiceController;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class confirmName extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $sender;
    public $student_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student_id, $sender)
    {
        $this->student_id = $student_id;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SchoolServiceController())->confirmName($this->student_id, $this->sender);
    }
}
