<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_log', function (Blueprint $table) {
            $table->increments('id_sys_log');
            $table->integer('id_user')->unsigned();
            $table->string('user_name');
            $table->string('ip_address', 20);
            $table->string('user_agent', 100);
            $table->string('kegiatan')->unique();
            $table->text('data_a')->nullable();
            $table->text('data_b')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_log');
    }
}
