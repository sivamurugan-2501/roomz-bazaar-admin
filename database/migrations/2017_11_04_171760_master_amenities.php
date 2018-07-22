<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterAmenities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tablename = "master_amenities";
        // code to create table
        /*Schema::create($tablename,function(Blueprint $table){
            $table->increments("id");
            $table->string("name");
            $table->text("icon_path");
            $table->integer("status");
            $table->integer("created_by");
            $table->integer("updated_by");
            $table->timestamps();
        });*/

        Schema::table($tablename,function(Blueprint $table){
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
        //
    }
}
