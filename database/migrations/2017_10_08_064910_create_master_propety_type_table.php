<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPropetyTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('master_property_type', function (Blueprint $table) {
            $table->increments('id');
             $table->string("name")->unique();
            $table->boolean("is_parent");
            $table->integer("parent");
            $table->integer("status");
            $table->integer("created_by");
            $table->integer("updated_by");
            $table->timestamps();
        });*/

        Schema::table("master_property_type",function(Blueprint $table){
            $table->boolean("is_parent")->default(false)->change();
            $table->integer("parent")->default(0)->change();
            $table->integer("status")->default(1)->change();
             $table->integer("updated_by")->default(0)->change();
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
