<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerOnPermissionModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backend_permission_module', function (Blueprint $table) {
            DB::unprepared("CREATE TRIGGER `insert_backend_permissions` AFTER INSERT ON `backend_permission_module`
FOR EACH ROW 
BEGIN
# Creating variable last_id to store autoincremental id from first insert statement did over backend_permissions table
DECLARE last_id INT;
# Creating variable perm_slug to store permission name from backend_permission_module table, where all spaces are replaced with - and characters are of lower case
DECLARE perm_slug VARCHAR(191);
SET perm_slug = REPLACE(LOWER(NEW.module_name), ' ', '-');
# Adding module entry in backend_permission table, which will work as base record entry for other permissions like add, edit, delete etc.
INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, perm_slug, NEW.module_name, 0, NEW.module_status);
# last_id variable value gets assigned by below statement
SELECT LAST_INSERT_ID() INTO last_id;
# Adding a entry to have add permission to module
INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, CONCAT('add-', perm_slug), CONCAT('Add ', NEW.module_name), last_id, NEW.module_status);
# Editing a entry to have add permission to module
INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, CONCAT('edit-', perm_slug), CONCAT('Edit ', NEW.module_name), last_id, NEW.module_status);
# Deleting a entry to have add permission to module
INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, CONCAT('delete-', perm_slug), CONCAT('Delete ', NEW.module_name), last_id, NEW.module_status);
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
            DB::unprepared('DROP TRIGGER IF EXISTS `insert_backend_permissions`;');
        });
    }
}
    