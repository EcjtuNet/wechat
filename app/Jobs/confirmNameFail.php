<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\Text;
use EasyWeChat;
use Illuminate\Contracts\Bus\SelfHandling;

class confirmNameFail extends Job implements SelfHandling
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
        $message = new Text(['content' => "学号错误，如有问题请联系管理员"]);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
