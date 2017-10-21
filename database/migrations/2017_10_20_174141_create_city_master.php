<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_master', function (Blueprint $table) {
            $table->increments('city_id')->comment('Serial City ID');
            $table->string('city_name', 255)->comment('City Name');
            $table->integer('state_id')->comment('State ID');
            $table->index('state_id', 'idx_state_id');
            $table->tinyInteger('city_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->index('city_status', 'idx_city_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this city details');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this city details');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this city details');
            $table->timestamp('deleted_at')->nullable()->comment('Deleted At');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_master');
    }
}
