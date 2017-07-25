<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\Text;
use EasyWeChat;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendPasswordFail extends Job implements SelfHandling, ShouldQueue
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
        $message = new Text(['content' => '密码错误请重新绑定(智慧交大密码默认身份证后六位),但如果你不小心输入了别人的学号又输入了错误的密码，你得先回复"我要解绑"解绑，再重新绑定']);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
