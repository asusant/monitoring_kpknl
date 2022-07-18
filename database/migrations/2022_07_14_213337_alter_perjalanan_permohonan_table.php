<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPerjalananPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perjalanan_permohonan', function (Blueprint $table) {
            $table->date('tgl_riil')->after('wkt_selesai_perjalanan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perjalanan_permohonan', function (Blueprint $table) {
            $table->dropColumn('tgl_riil');
        });
    }
}
