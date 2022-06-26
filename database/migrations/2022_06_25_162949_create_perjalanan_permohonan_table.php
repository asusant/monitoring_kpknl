<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerjalananPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perjalanan_permohonan', function (Blueprint $table) {
            $table->increments('id_perjalanan');
            $table->integer('id_permohonan')->unsigned();
            $table->integer('id_tahap')->unsigned();
            $table->date('wkt_mulai_perjalanan');
            $table->tinyInteger('sts_perjalanan');
            $table->integer('id_user_perjalanan')->unsigned();
            $table->text('catatan');
            $table->boolean('is_deadline_manual');
            $table->dateTime('next_deadline');
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
        Schema::dropIfExists('perjalanan_permohonan');
    }
}
