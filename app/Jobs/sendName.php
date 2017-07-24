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
        $message = new Text(['content' => "$this->name 同学，确定绑定请回复 \"'确定绑定'或'确认绑定'\"; 若非本人，可回复\"bd+学号\"重新绑定"]);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
