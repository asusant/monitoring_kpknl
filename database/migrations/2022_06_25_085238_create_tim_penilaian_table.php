<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimPenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_penilaian', function (Blueprint $table) {
            $table->increments('id_tim_penilaian');
            $table->integer('id_user_tim_penilaian');
            $table->string('nm_tim_penilaian');
            $table->string('nip_tim_penilaian', 50);
            $table->tinyInteger('urutan_tim_penilaian');
            $table->boolean('is_aktif')->default(0);
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
        Schema::dropIfExists('tim_penilaian');
    }
}
