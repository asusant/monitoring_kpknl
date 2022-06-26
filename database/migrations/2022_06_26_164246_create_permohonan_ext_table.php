<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_ext', function (Blueprint $table) {
            $table->integer('id_permohonan')->primary();
            $table->boolean('dok_id_obj');
            $table->boolean('dok_jns_nilai');
            $table->boolean('dok_latar_belakang');
            $table->boolean('dok_tujuan');
            $table->boolean('dok_legalitas');
            $table->boolean('dok_desc_obj');
            $table->boolean('dok_tata_usaha');
            $table->boolean('dok_sk_berat_volume');
            $table->boolean('dok_laporan_penilai');
            $table->boolean('dok_fc_ba_penyitaan');
            $table->boolean('dok_proposal');
            $table->boolean('dok_laporan_keuangan');
            $table->boolean('dok_laporan_apip');
            $table->string('dok_lainnya');
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
        Schema::dropIfExists('permohonan_ext');
    }
}
