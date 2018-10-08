<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableModifyColumnTotaSquareFeet1PropertyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_master', function (Blueprint $table) {
            $table->integer('total_square_feet')->after('per_square_feet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_master', function (Blueprint $table) {
            //
        });
    }
}
