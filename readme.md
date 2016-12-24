# rixinwx服务号

## 依赖

 * laravel5.1
 * easywechat
 * requests
 
## 部署

 * docker pull ecjtunet/php
 *  docker run --rm -v $(pwd):/app composer/composer install
 
 
## 完成功能
 
 * 对关键字进行筛选(查成绩，查课表，绑定学号，绑定密码)
 * 第一次回复查成绩（未绑定状态）,
 记录用户微信信息，并返回绑定操作帮助信息

## TODO
验证用户姓氏
验证绑定密码
更改绑定关键字
返回成绩
查询15班级课表
缓存
 