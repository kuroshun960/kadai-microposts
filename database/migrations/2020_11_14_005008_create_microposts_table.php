<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicropostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microposts', function (Blueprint $table) {
            
            //各投稿を識別するid
            $table->bigIncrements('id');
            
            //投稿したユーザーのID
            $table->unsignedBigInteger('user_id');
            
            //投稿内容
            $table->string('content');
            $table->timestamps();
            
            // 外部キー制約(データベース側の機能)
            //ユーザーと投稿に「つながり」をもたせて、整合性をもたせる
            
            //（外部キーを設定するカラム）（参照先のカラム）（参照先のテーブル）(デリート時)
            $table->foreign('user_id')->references('id')->on('users');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('microposts');
    }
}
