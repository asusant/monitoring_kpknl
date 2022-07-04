<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_ext', function (Blueprint $table) {
            $table->integer('id_ketua_tim')->unsigned()->after('dok_lainnya')->nullable();
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
            $table->dropColumn('id_ketua_tim');
        });
    }
}
