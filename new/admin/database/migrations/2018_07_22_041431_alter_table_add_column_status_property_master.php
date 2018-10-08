<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddColumnStatusPropertyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_master', function (Blueprint $table) {
            $table->tinyinteger('property_status')->after('others')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active')->index('idx_property_status');
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
