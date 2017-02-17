<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat\Message\Text;
use EasyWeChat;

class sendExamFail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $sender;
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
        $message = new Text(['content' => '小新暂时查不到你的信息，过会再来吧']);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
