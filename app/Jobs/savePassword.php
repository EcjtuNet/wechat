<?php

namespace App\Jobs;

use App\Http\Controllers\SchoolServiceController;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class savePassword extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $student_id;
    public $password;
    public $sender;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student_id, $password, $sender)
    {
        $this->student_id = $student_id;
        $this->password = $password;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SchoolServiceController())->savePassword($this->student_id, $this->password, $this->sender);
    }
}
