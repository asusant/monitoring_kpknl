<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysModulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->integer('id_modul_group')->unsigned();
            $table->string('route_prefix')->nullable()->unique();
            $table->string('nm_modul', 100);
            $table->smallInteger('urutan');
            $table->boolean('is_tampil');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_modul_group')->references('id_modul_group')->on('sys_modul_group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_modul');
    }
}
