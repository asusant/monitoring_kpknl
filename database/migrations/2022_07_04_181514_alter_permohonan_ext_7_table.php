<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanExt7Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->string('hal_st_tim_penilai', 192)->after('hal_nd_st_tim_penilai')->nullable();
            $table->date('tgl_st_tim_penilai')->after('hal_nd_st_tim_penilai')->nullable();
            $table->string('no_st_tim_penilai', 50)->after('hal_nd_st_tim_penilai')->nullable();
            $table->date('jadwal_survey')->after('hal_nd_st_tim_penilai')->nullable();
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
            $table->dropColumn('hal_st_tim_penilai');
            $table->dropColumn('tgl_st_tim_penilai');
            $table->dropColumn('no_st_tim_penilai');
            $table->dropColumn('jadwal_survey');
        });
    }
}
