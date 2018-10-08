<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyMasterInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_master_int', function (Blueprint $table) {
            $table->increments('entity_id')->comment('Serial Entity ID');
            $table->integer('attribute_id')->comment('Attribute ID');
            $table->integer('property_id')->comment('Property ID');
            $table->index(array('property_id', 'attribute_id'), 'idx_property_attribute_id');
            $table->integer('value')->nullable()->comment('Value, here all integer attributes details will be stored');
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
        Schema::dropIfExists('property_master_int');
    }
}
