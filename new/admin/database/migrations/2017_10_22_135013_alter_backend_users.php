<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBackendUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backend_users', function (Blueprint $table) {
            $table->string('user_password', 255)->nullable()->comment('User Password')->after('user_activation_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backend_users', function (Blueprint $table) {
            $table->dropColumn('user_password');
        });
    }
}
