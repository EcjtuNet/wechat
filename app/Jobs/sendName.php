<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\Text;
use EasyWeChat;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendName extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $sender;
    public $name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $sender)
    {
        $this->name = $name;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = new Text(['content' => "$this->name 同学是你吗？如果是你的话，请输入\"mm+智慧交大密码\"进行绑定(例如:mm111111)，如果不是你，你可以重新输入\"bd+学号\"进行绑定"]);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
