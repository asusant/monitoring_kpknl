<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJnsPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jns_permohonan', function (Blueprint $table) {
            $table->boolean('is_aktif')->default(0);
            $table->string('desc_jns_permohonan', 192)->nullable()->after('nm_jns_permohonan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jns_permohonan', function (Blueprint $table) {
            $table->dropColumn('is_aktif');
            $table->dropColumn('desc_jns_permohonan');
        });
    }
}
