<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanExt6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->string('hal_nd_st_tim_penilai', 192)->after('is_nd_st_penilai_jadi')->nullable();
            $table->date('tgl_nd_st_tim_penilai')->after('is_nd_st_penilai_jadi')->nullable();
            $table->string('no_nd_st_tim_penilai', 50)->after('is_nd_st_penilai_jadi')->nullable();

            $table->string('hal_nd_survey_tim_penilai', 192)->after('is_nd_st_penilai_jadi')->nullable();
            $table->date('tgl_nd_survey_tim_penilai')->after('is_nd_st_penilai_jadi')->nullable();
            $table->string('no_nd_survey_tim_penilai', 50)->after('is_nd_st_penilai_jadi')->nullable();
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
            $table->dropColumn('hal_nd_st_tim_penilai');
            $table->dropColumn('tgl_nd_st_tim_penilai');
            $table->dropColumn('no_nd_st_tim_penilai');

            $table->dropColumn('hal_nd_survey_tim_penilai');
            $table->dropColumn('tgl_nd_survey_tim_penilai');
            $table->dropColumn('no_nd_survey_tim_penilai');
        });
    }
}
