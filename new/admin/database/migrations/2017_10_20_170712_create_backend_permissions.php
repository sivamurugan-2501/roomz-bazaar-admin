<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_permissions', function (Blueprint $table) {
            $table->increments('permission_id')->comment('Serial Permission ID');
            $table->integer('module_id')->nullable()->comment('Permission Module ID');
            $table->index('module_id', 'idx_module_id');
            $table->string('permission_key', 191)->comment('Permission Key, using this only admin panel users rights are getting decided');
            $table->unique('permission_key', 'idx_permission_key');
            $table->string('permission_label', 255)->comment('Permission Label just shown to admin panel users, to identify permission at ease');
            $table->integer('permission_parent')->nullable()->default(0)->comment('Parent ID for this permission entry, means here we can add menu list like a tree hierarchy');
            $table->tinyInteger('permission_status')->nullable()->default(1)->comment('Permission Status: 0=Inactive, 1=Active');
            $table->index('permission_status', 'idx_permission_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this permission entry');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this permission entry');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this permission entry');
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
        Schema::dropIfExists('backend_permissions');
    }
}
