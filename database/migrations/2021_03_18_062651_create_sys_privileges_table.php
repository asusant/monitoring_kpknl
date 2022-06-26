<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_privilege', function (Blueprint $table) {
            $table->integer('id_modul')->unsigned();
            $table->integer('id_role')->unsigned();
            $table->boolean('a_read');
            $table->boolean('a_create');
            $table->boolean('a_update');
            $table->boolean('a_delete');
            $table->boolean('a_validate');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->primary(['id_modul', 'id_role']);

            $table->foreign('id_modul')->references('id_modul')->on('sys_modul')->onDelete('cascade');
            $table->foreign('id_role')->references('id_role')->on('sys_role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_privilege');
    }
}
