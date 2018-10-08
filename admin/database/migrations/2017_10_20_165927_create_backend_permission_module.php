<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendPermissionModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_permission_module', function (Blueprint $table) {
            $table->increments('module_id')->comment('Serial Permission Module ID');
            $table->string('module_name', 191)->nullable()->comment('Permission Module Name, Basically it’s nothing but a admin panel, menu name. E.g. User Management, Roles Management etc.');
            $table->unique('module_name', 'idx_module_name');
            $table->tinyInteger('module_status')->nullable()->default(1)->comment('Permission Module Status: 0=Inactive, 1=Active');
            $table->index('module_status', 'idx_module_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this permission module entry');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this permission module entry');
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
        Schema::dropIfExists('backend_permission_module');
    }
}
