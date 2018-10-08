<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTypeAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_type_attributes', function (Blueprint $table) {
            $table->increments('attribute_id')->comment('Serial Property Type Attribute ID');
            $table->string('attribute_name', 150)->comment('Attribute Name/Key which will be used for creating dynamic form elements');
            $table->unique('attribute_name', 'idx_attribute_name');
            $table->string('attribute_label', 255)->comment('Label used for display purpose');
            $table->string('attribute_for_type', 255)->comment('Here, multiple property type id\'s will be stored as comma separated');
            $table->enum('attribute_datatype', ['INTEGER', 'DECIMAL', 'SELECT', 'RADIO' , 'CHECKBOX', 'TEXTAREA', 'TEXTFIELD', 'DATETIME'])->comment('Used to define datatype for attribute');
            $table->string('attribute_placeholder', 255)->comment('Placeholder used as informational text');
            $table->tinyInteger('attribute_system_defined')->nullable()->default(0)->comment('Attribute System Defined? 0=No, 1=Yes. If attribute is system defined, then it will not available for deletion.');
            $table->index('attribute_system_defined', 'idx_attribute_system_defined');
            $table->string('attribute_default_value', 255)->comment('Default Value');
            $table->tinyInteger('attribute_master_linked')->nullable()->default(0)->comment('Is Attribute Master Linked: 0=No, 1=Yes');
            $table->string('attribute_master_table_name', 255)->comment('Master Table Name');
            $table->tinyInteger('attribute_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->integer('created_by')->nullable()->comment('User ID, who have created this user entry');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this user entry');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
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
        Schema::dropIfExists('property_type_attributes');
    }
}
