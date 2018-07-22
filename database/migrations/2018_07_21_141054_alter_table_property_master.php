<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePropertyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_master', function (Blueprint $table) {
            if( Schema::hasColumn('property_master', 'prperty_type') ) {
                $table->dropColumn('prperty_type');
            }
            if( Schema::hasColumn('property_master', 'state') ) {
                $table->dropColumn('state');
            }
            if( Schema::hasColumn('property_master', 'city') ) {
                $table->dropColumn('city');
            }
            if( Schema::hasColumn('property_master', 'negotiable') ) {
                $table->dropColumn('negotiable');
            }
            if( Schema::hasColumn('property_master', 'maintenance_include') ) {
                $table->dropColumn('maintenance_include');
            }
            if( Schema::hasColumn('property_master', 'parking') ) {
                $table->dropColumn('parking');
            }
            if( Schema::hasColumn('property_master', 'gym') ) {
                $table->dropColumn('gym');
            }
            if( Schema::hasColumn('property_master', 'water_supply') ) {
                $table->dropColumn('water_supply');
            }
            if( Schema::hasColumn('property_master', 'garden') ) {
                $table->dropColumn('garden');
            }
            if( Schema::hasColumn('property_master', 'age') ) {
                $table->dropColumn('age');
            }
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
