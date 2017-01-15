<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\Text;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat;

class sendScore extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $sender;
    public $scores;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sender, $scores)
    {
        $this->sender = $sender;
        $this->scores = $scores;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $msg = "你的成绩 \n =========== \n";
        if (is_array($this->scores))
        $message = new Text(['content' => $msg]);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
