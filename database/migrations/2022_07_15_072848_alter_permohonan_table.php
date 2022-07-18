<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->integer('id_jns_permohonan')->unsigned()->after('id_permohonan')->nullable();
        });

        if (Schema::hasColumn('permohonan', 'jns_permohonan'))
        {
            Schema::table('permohonan', function (Blueprint $table)
            {
                $table->dropColumn('jns_permohonan');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('id_jns_permohonan');
        });
    }
}
