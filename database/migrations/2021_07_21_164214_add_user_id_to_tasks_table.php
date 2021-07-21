<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            //$table->string('content');   //こちらは　2021_07_15_091649_create_tasks_table.php　で定義済みですので削除です
            //$table->string('user_id'); //これ削除17行目と重複です
            
            // 外部キー制約
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
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            //$table->dropColumn('content'); //こちらは　2021_07_15_091649_create_tasks_table.php　で定義済みですので削除です
        });
    }
}