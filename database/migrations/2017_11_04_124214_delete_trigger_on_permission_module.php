<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTriggerOnPermissionModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backend_permission_module', function (Blueprint $table) {
            DB::unprepared("CREATE TRIGGER `delete_backend_permisions` AFTER DELETE ON `backend_permission_module`
FOR EACH ROW 
BEGIN
DECLARE last_id INT;
SET last_id = OLD.module_id;
DELETE FROM `backend_permissions` WHERE `backend_permissions`.`module_id` = last_id;
END");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backend_permission_module', function (Blueprint $table) {
            DB::unprepared("DROP TRIGGER IF EXISTS `delete_backend_permisions`;");
        });
    }
}
