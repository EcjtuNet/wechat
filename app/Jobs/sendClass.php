<?php

namespace App\Jobs;

use App\Http\Controllers\debugController;
use App\Jobs\Job;
use EasyWeChat\Message\News;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat;

class sendClass extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $sender;
    public $class;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sender,$class)
    {
        $this->sender = $sender;
        $this->class  = $class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $week = date("l");
        $week = lcfirst($week);
        $msg = "你今天的课表 \n===========\n";
        foreach ($this->class['data']['class_list']["$week"] as $class) {
            if ($class != '') {
               $msg = $msg . $class . "\n"." ==========\n";
            }
        }

        $message = new News([
            'title'  =>  '你的课表',
            'description' => "$msg",

        ]);

        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
