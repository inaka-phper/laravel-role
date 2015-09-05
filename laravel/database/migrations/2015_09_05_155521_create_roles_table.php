<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // ロール名
            $table->boolean('create')->default(0); // 新規作成権限
            $table->boolean('read')->default(0);   // 閲覧権限
            $table->boolean('update')->default(0); // 編集権限
            $table->boolean('delete')->default(0); // 削除権限
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
        Schema::drop('roles');
    }
}
