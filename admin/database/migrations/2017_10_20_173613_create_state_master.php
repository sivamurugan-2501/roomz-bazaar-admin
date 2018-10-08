<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_master', function (Blueprint $table) {
            $table->increments('state_id')->comment('Serial State ID');
            $table->string('state_name', 255)->comment('State Name');
            $table->string('country_code', 10)->comment('Country Code');
            $table->string('state_code', 10)->comment('State Code');
            $table->tinyInteger('state_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->index('state_status', 'idx_state_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this state details');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this state details');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this state details');
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
        Schema::dropIfExists('state_master');
    }
}
