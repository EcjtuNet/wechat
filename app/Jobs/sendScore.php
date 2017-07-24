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
        $msg = "你的成绩 \n===========\n";
        foreach ($this->scores['data']['score_list'] as $score)
        {
            $msg = $msg . " 课程类型:  " . $score['classRequirement'] . " \n ";
            $msg = $msg . "课程名称:  " . $score['objectName'] . " \n ";
            $msg = $msg . "课程成绩: " . $score['score'] . " \n ";
            $msg = $msg . "课程学分: " . $score['credit'] . " \n " . " ==========\n";
        }

        $message = new News([
              'title'  =>  '你的成绩',
              'description' => "$msg",

            ]);

        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
