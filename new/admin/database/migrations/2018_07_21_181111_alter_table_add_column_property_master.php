<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddColumnPropertyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_master', function (Blueprint $table) {
            $table->integer('property_type_id')->after('name')->nullable()->default(0)->comment('Foreign key refeameces property_type_master > type_id')->index('idx_property_type_id');
            $table->integer('city_id')->after('address')->nullable()->default(0)->comment('City ID');
            $table->integer('state_id')->after('city_id')->nullable()->default(0)->comment('State ID');
            $table->integer('country_id')->after('state_id')->nullable()->default(0)->comment('Country ID');
            $table->integer('property_age')->after('landmark')->nullable()->default(0)->comment('Property Age');
            $table->enum('negotiable', array('yes', 'no'))->after('total_rate')->nullable()->default('no')->comment('Negotiable');
            $table->enum('maintenance_include', array('yes', 'no'))->after('rent_per_month')->nullable()->default('no')->comment('Maintenance included or not');
            $table->enum('parking', array('yes', 'no'))->after('maintenance_include')->nullable()->default('no')->comment('Parking available or not');
            $table->enum('gym', array('yes', 'no'))->after('parking')->nullable()->default('no')->comment('Gym available or not');
            $table->enum('water_supply', array('yes', 'no'))->after('gym')->nullable()->default('no')->comment('Water supply available or not');
            $table->enum('garden', array('yes', 'no'))->after('water_supply')->nullable()->default('no')->comment('Garden space available or not');
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
