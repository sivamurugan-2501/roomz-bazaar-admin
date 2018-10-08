<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OldPropertySchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('old_property', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('prperty_type',100);
            $table->string('show_as',100);
            $table->text('address');
            $table->string('state');
            $table->string('city');
            $table->string('landmark');
            $table->integer('age');
            $table->integer('total_floors');
            $table->integer('floor_no');
            $table->integer('per_square_feet');
            $table->integer('tota_square_feet');
            $table->integer('carpet_area');
            $table->integer('usable_area');
            $table->integer('total_rate');
            $table->string('negotiable');
            $table->float('advance_deposite');
            $table->float('rent_per_month');
            $table->string('maintenance_include');
            $table->string('parking');
            $table->string('gym');
            $table->string('water_supply');
            $table->string('garden');
            $table->string('others');
            $table->timestamps();
             $table->integer("transaction_type")->default(0);
            $table->integer("possession_type")->default(0);
            $table->integer("possession_year")->default(0);
            $table->integer('age')->default(0)->change();

            $table->string("address")->default("")->change();
            $table->integer("no_of_bedroom")->default(0);
            $table->integer("no_of_bathroom")->default(0);
            $table->string("amenities")->default(null);$table->integer("no_of_balcony")->default(0);
            $table->integer("status")->default(1);
            $table->integer("for_gender")->default(0);
            $table->decimal("maintenance_charge",15,2)->default(0);
        });*/

        Schema::table("old_property",function(Blueprint $table){
            /*$table->boolean("furnishes")->default(false);
            $table->string("address")->default("-")->change();
            $table->integer("state")->default(0)->change();
            $table->integer("city")->default(0)->change();
            $table->string("landmark")->default("-")->change();
            $table->integer('age')->default(0)->change();
           
            $table->renameColumn("prperty_type","property_type")->default(0)->change();
            $table->renameColumn("advance_deposite","advance_deposit")->default(0)->change();
            $table->renameColumn("rent_per_month","rent")->default(0)->change();
            $table->renameColumn("advance_deposite","advance_deposit")->default(0)->change();
            $table->renameColumn("rent_per_month","rent")->default(0)->change();
            $table->renameColumn("maintenance_include","includes_maintenance")->integer(1)->default(0)->change();
            $table->integer("carpet_area")->default(0)->change();
            $table->integer("usable_area")->default(0)->change();
            $table->decimal("total_rate",15,2)->default(0)->change();
            $table->integer("negotiable")->default(0)->change();
            //$table->integer("includes_maintenance")->default(0)->change();
            $table->integer("parking")->default(0)->change();
            $table->string("amenities")->default("[]")->change();*/
        });

        /* Schema::table("property",function(Blueprint $table){
            $table->bigInteger("advance_deposit")->default(0)->change();
            $table->bigInteger("rent")->default(0)->change();
           // $table->string("maintenance_include")->default(null)->change();
            $table->string('parking')->default(null)->change();  
            $table->string('gym')->default(null)->change();
            $table->string('water_supply')->default(null)->change();    
            $table->string('others')->default(null)->change();  
        }); 

        Schema::table("property",function(Blueprint $table){
            $table->smallInteger("includes_stamp_paper_charge")->default(0);
        });*/

        Schema::table("property",function(Blueprint $table){
            $table->double("other_charges")->default(0);
        });
    }

    


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_property');
    }
}
