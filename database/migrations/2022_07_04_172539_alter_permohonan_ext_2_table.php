<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanExt2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->string('hal_nd_tim_penilai', 192)->after('id_ketua_tim')->nullable();
            $table->date('tgl_nd_tim_penilai')->after('id_ketua_tim')->nullable();
            $table->string('no_nd_tim_penilai', 50)->after('id_ketua_tim')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->dropColumn('hal_nd_tim_penilai');
            $table->dropColumn('tgl_nd_tim_penilai');
            $table->dropColumn('no_nd_tim_penilai');
        });
    }
}
