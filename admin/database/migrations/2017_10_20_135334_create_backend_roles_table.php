<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_roles', function (Blueprint $table) {
            $table->increments('role_id')->comment('Serial Role ID');
            $table->string('role_name', 50)->nullable()->comment('Role Name');
            $table->tinyInteger('role_status')->nullable()->default(1)->comment('Role Status: 0=Inactive, 1=Active');
            $table->index('role_status', 'idx_role_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this role entry');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this role entry');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this role entry');
            $table->timestamp('deleted_at')->nullable()->comment('Deleted At');
        });
        //DB:statement("ALTER TABLE `backend_roles` ADD COLUMN `updated_at` TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At' AFTER `created_at`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backend_roles');
    }
}
