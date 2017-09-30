<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_info', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_info');
    }
}
