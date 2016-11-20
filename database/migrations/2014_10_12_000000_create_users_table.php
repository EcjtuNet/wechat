<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            //微信基本信息
            $table->string('subscribe');
            $table->string('openid');
            $table->string('nickname');
            $table->string('sex');
            $table->string('language');
            $table->string('city');
            $table->string('province');
            $table->string('country');
            $table->string('headimgurl');
            $table->string('subscribe_time');
            $table->string('remark');
            $table->string('groupid');
            $table->string('tagid_list');
            //校园服务信息
            $table->string('student_id')->nullable();
            $table->string('password')->nullable();
            $table->boolean('bound')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
