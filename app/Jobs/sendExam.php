<?php

namespace App\Jobs;

use App\Http\Controllers\debugController;
use App\Jobs\Job;
use EasyWeChat\Message\Text;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat;

class sendExam extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $sender;
    public $exam;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sender,$exam)
    {
        $this->sender = $sender;
        $this->exam  = $exam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $message = new News([
        //       'title'  =>  '你的考试安排',
        //       'image'  =>  'http://mmbiz.qpic.cn/mmbiz_jpg/J1iaWB1VlOykPibTacZHD7IvibkH7VH88vUMJlwvMOxqT0aHvFILOlkMYibxlErZD1osvTEb9QdaCtn2ibw15t2lq7g/0?wx_fmt=jpeg',
        //       'description' => '点击查看考试安排',

        //     ]);
        $msg = "你的考试安排 \n===========\n";
        foreach ($this->exam['data']['exam_list'] as $exam)
        {
            $msg = $msg . "课程性质: " . $exam['课程性质'] . " \n ";
            $msg = $msg . "课程名称: " . $exam['课程名称'] . " \n ";
            $msg = $msg . "考试地点: " . $exam['考试地点'] . " \n ";
            $msg = $msg . "班级名称: " . $exam['班级名称'] . " \n ";
            $msg = $msg . "考试时间: " . $exam['考试时间'] . " \n ";
            $msg = $msg . "考试周次: " . $exam['考试周次'] . " \n ";
            $msg = $msg . "学生人数: " . $exam['学生人数'] . " \n " . " ==========\n";
        }
        $message = new Text(['content' => $msg]);
        EasyWeChat::staff()->message($message)->to($this->sender)->send();
    }
}
