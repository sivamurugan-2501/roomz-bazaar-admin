<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->increments('image_id')->comment('Serial Image ID For Property');
            $table->string('image_name', 255)->comment('Image Name Stored Inside Storage Folder');
            $table->string('image_orig_name', 255)->comment('Original Image Name');
            $table->string('image_size', 20)->comment('Image Size');
            $table->string('image_mime_type', 255)->comment('Image MIME Type');
            $table->string('image_path', 255)->comment('Image Stored Path');
            $table->tinyInteger('image_status')->nullable()->default(1)->comment('Status: 0=Inactive, 1=Active');
            $table->index('image_status', 'idx_image_status');
            $table->integer('property_master_id')->comment('Foreign key referring to property_master >> id field');
            $table->index('property_master_id', 'idx_property_master_id');
            $table->integer('created_by')->nullable()->comment('User ID, who have added this image details');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Created At');
            $table->integer('updated_by')->nullable()->comment('User ID, who have updated this image details');
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->comment('Updated At');
            $table->integer('deleted_by')->nullable()->comment('User ID, who have deleted this image details');
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
        Schema::dropIfExists('property_images');
    }
}
