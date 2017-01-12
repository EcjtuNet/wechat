<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\Text;
use EasyWeChat;
use Illuminate\Contracts\Bus\SelfHandling;

class sendPasswordFail extends Job implements SelfHandling
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
        $message = new Text(['content' => '密码错误请重新绑定(智慧交大密码默认身份证后六位)']);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
