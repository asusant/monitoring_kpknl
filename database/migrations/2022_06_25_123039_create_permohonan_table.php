<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->increments('id_permohonan');
            $table->string('no_permohonan', 50);
            $table->tinyInteger('n_verifikasi')->default(1);
            $table->string('asal_surat');
            $table->string('no_surat', 50);
            $table->date('tgl_surat');
            $table->string('kl_eselon_1');
            $table->string('satker');
            $table->string('jns_aset');
            $table->string('dalam_rangka');
            $table->string('tindak_lanjut_bmn');
            $table->string('pemilik_obj_penilaian');
            $table->string('jns_obj_penilaian');
            $table->text('desc_obj_penilaian');
            $table->bigInteger('indikasi_nilai')->default(0);
            $table->date('tgl_terima_ka_kantor');
            $table->date('tgl_terima_verifikator');
            $table->date('batas_verifikasi');
            $table->text('ket_khusus')->nullable();
            $table->integer('id_tahap_aktif')->default(1);
            $table->dateTime('deadline_tahap_aktif')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('id_tahap_sebelum')->nullable();
            $table->dateTime('deadline_tahap_sebelum')->nullable();
            $table->integer('id_user_tahap_sebelum')->nullable();
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
        Schema::dropIfExists('permohonan');
    }
}
