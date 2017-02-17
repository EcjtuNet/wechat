# rixinwx订阅号

## 依赖
 * laravel5.1
 * easywechat
 
## 部署
 * docker pull ecjtunet/php
 * docker run --rm -v $(pwd):/app composer/composer install
 * 运行supervisor,监听wechat-worker-supervisor.conf任务
 
## 思路
 ![](Wechat Controller.png)
 
## 完成功能
* 保存用户详情
* 绑定学号
* 绑定密码
* 查询成绩
* 查询15级课表
* 查询考试安排

## TODO
* 一卡通查询功能
 