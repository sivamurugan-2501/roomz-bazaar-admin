<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTriggerOnPermissionModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backend_permission_module', function (Blueprint $table) {
            DB::unprepared("CREATE TRIGGER `update_backend_permissions` AFTER UPDATE ON `backend_permission_module`
FOR EACH ROW 
BEGIN
# Creating variable last_id to store autoincremental id from first insert statement did over backend_permissions table
DECLARE last_id INT;
# Creating variable new_perm_slug to store permission name from backend_permission_module table, where all spaces are replaced with - and characters are of lower case
DECLARE new_perm_slug VARCHAR(191);
# Creating variable old_perm_slug to store permission name from backend_permission_module table, where all spaces are relaced with - and characters are of lower case
DECLARE old_perm_slug VARCHAR(191);
SET last_id = OLD.module_id;
SET new_perm_slug = REPLACE(LOWER(NEW.module_name), ' ', '-');
SET old_perm_slug = REPLACE(LOWER(OLD.module_name), ' ', '-');
# Updating permission_key & permission_label from backend_permissions table based on field module_id
UPDATE `backend_permissions` SET `permission_key` = REPLACE(`permission_key`, old_perm_slug, new_perm_slug), `permission_label` = REPLACE(`permission_label`, OLD.module_name, NEW.module_name), `permission_status` = NEW.`module_status` WHERE `module_id` = last_id;
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
