<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysModulGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_modul_group', function (Blueprint $table) {
            $table->increments('id_modul_group');
            $table->integer('id_menu_group')->unsigned();
            // $table->string('route_prefix')->nullable()->unique();
            $table->string('nm_modul_group', 100);
            $table->string('icon_modul_group', 50);
            $table->smallInteger('urutan');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_menu_group')->references('id_menu_group')->on('sys_menu_group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_modul_group');
    }
}
