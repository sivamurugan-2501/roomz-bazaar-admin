<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_master', function (Blueprint $table) {
            $table->increments('property_id')->comment('Serial Property ID');
            $table->string('property_code', 150)->comment('Property Short Code');
            $table->unique('property_code', 'idx_property_code');
            $table->tinyInteger('property_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active, 2=Suspended');
            $table->integer('created_by')->nullable()->comment('User ID, who have created this user entry');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this user entry');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this user entry');
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
        Schema::dropIfExists('property_master');
    }
}
