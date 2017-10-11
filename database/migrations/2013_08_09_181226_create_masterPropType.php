<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPropType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return vpopmail_del_domain(domain)
     */
    public function up()
    {
        Schema::create('master_property_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->unique();
            $table->boolean("is_parent");
            $table->int("parent");
            $table->int("status");
            $table->int("created_by");
            $table->int("update_by");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_property_type');
    }
}
