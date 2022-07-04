<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanExt4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->boolean('dok_permohonan_penilaian')->after('hal_sk_tim_penilai')->nullable();
            $table->boolean('dok_sk_tim_penilaian')->after('hal_sk_tim_penilai')->nullable();
            $table->string('dok_permohonan_lain', 255)->after('hal_sk_tim_penilai')->nullable();
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
            $table->dropColumn('dok_permohonan_penilaian');
            $table->dropColumn('dok_sk_tim_penilaian');
            $table->dropColumn('dok_permohonan_lain');
        });
    }
}
