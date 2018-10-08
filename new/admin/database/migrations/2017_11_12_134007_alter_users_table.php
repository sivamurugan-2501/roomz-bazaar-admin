<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_activation_key', 255)->nullable()->comment('After, user registration this key is used for validating proper user.')->after('remember_token');
            $table->string('user_password_reset_key', 255)->nullable()->comment('Password reset key, used for Forgot Password Functionality')->after('user_activation_key');
            $table->tinyInteger('require_password_change')->nullable()->default(0)->comment('Required for user to change his/her passsword after doing a login/before login.')->after('user_password_reset_key');
            $table->index('require_password_change', 'idx_require_password_change');
            $table->integer('role_id')->nullable()->comment('Role ID Foreign Key Referring To backend_roles table')->after('require_password_change');
            $table->index('role_id', 'idx_role_id');
            $table->tinyInteger('user_status')->nullable()->default(0)->comment('User Account Status: 0=Inactive, 1=Active, 2=suspended. User Status will get auto changed to 1, when user_activation_key is matched by the user')->after('role_id');
            $table->index('user_status', 'idx_user_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have created this user entry')->after('user_status');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this user entry')->after('created_at');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_activation_key');
            $table->dropColumn('user_password_reset_key');
            $table->dropColumn('require_password_change');
            $table->dropColumn('role_id');
            $table->dropColumn('user_status');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
            $table->dropColumn('deleted_at');
        });
    }
}
