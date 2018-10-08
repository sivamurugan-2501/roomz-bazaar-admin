<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_master', function (Blueprint $table) {
            $table->increments('country_id')->comment('Serial Country ID');
            $table->string('country_name', 191)->comment('Country Name');
            $table->unique('country_name', 'idx_country_name');
            $table->string('country_code', 10)->comment('Country Code');
            $table->unique('country_code', 'idx_country_code');
            $table->tinyInteger('country_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->index('country_status', 'idx_country_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this country details');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this country details');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this country details');
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
        Schema::dropIfExists('country_master');
    }
}
