<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTypeMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_type_master', function (Blueprint $table) {
            $table->increments('type_id')->comment('Serial Property Type ID');
            $table->string('type_name', 150)->comment('Property Type Name');
            $table->unique('type_name', 'idx_type_name');
            $table->tinyInteger('type_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->index('type_status', 'idx_type_status');
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
        Schema::dropIfExists('property_type_master');
    }
}
