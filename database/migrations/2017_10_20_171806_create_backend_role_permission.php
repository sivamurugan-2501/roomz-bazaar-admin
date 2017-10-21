<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_role_permission', function (Blueprint $table) {
            $table->increments('role_id')->comment('Role ID');
            $table->integer('permission_id')->nullable()->comment('Permission ID');
            $table->index('permission_id', 'idx_permission_id');
            $table->tinyInteger('role_permission_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->index('role_permission_status', 'idx_role_permission_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this permission entry against role');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this permission entry against role');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this permission module entry');
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
        Schema::dropIfExists('backend_role_permission');
    }
}
