<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahap_monitoring', function (Blueprint $table) {
            $table->increments('id_tahap');
            $table->string('nm_tahap');
            $table->tinyInteger('deadline_hari')->default(0);
            $table->tinyInteger('deadline_jam')->default(0);
            $table->tinyInteger('urutan_tahap');
            $table->string('jns_tahap');
            $table->string('ext_form_route')->nullable();
            $table->boolean('is_aktif')->default(1);
            $table->integer('id_role_tahap')->unsigned();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('tahap_monitoring');
    }
}
