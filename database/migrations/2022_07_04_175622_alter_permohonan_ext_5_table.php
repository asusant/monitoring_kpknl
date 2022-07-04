<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanExt5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->boolean('is_nd_st_penilai_jadi')->after('dok_permohonan_penilaian')->nullable();
            $table->boolean('is_nd_survey_jadi')->after('dok_permohonan_penilaian')->nullable();
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
            $table->dropColumn('is_nd_st_penilai_jadi');
            $table->dropColumn('is_nd_survey_jadi');
        });
    }
}
