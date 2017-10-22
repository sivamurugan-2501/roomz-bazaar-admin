<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_users', function (Blueprint $table) {
            $table->increments('user_id')->comment('Serial User ID');
            $table->string('user_name', 255)->nullable()->comment('User Full Name');
            $table->string('user_email', 191)->comment('User Email ID');
            $table->unique('user_email', 'idx_user_email');
            $table->string('user_activation_key', 255)->nullable()->comment('After, user registration this key is used for validating proper user.');
            $table->string('user_password_reset_key', 255)->nullable()->comment('Password reset key, used for Forgot Password Functionality');
            $table->tinyInteger('require_password_change')->nullable()->default(0)->comment('Required for user to change his/her passsword after doing a login/before login.');
            $table->index('require_password_change', 'idx_require_password_change');
            $table->tinyInteger('user_status')->nullable()->default(0)->comment('User Account Status: 0=Inactive, 1=Active, 2=suspended. User Status will get auto changed to 1, when user_activation_key is matched by the user');
            $table->index('user_status', 'idx_user_status');
            $table->integer('created_by')->nullable()->comment('User ID, who have created this user entry');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this user entry');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this user entry');
            $table->timestamp('deleted_at')->nullable()->comment('Deleted At');
        });
        //DB::statement('CREATE UNIQUE INDEX `idx_user_email` ON `backend_users` (`user_email`(100));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backend_users');
    }
}
