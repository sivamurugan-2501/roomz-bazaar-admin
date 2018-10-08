<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyImages extends Model
{
    //fillable fields
	protected $fillable = ['image_name', 'image_orig_name', 'image_size', 'image_mime_type', 'image_path', 'image_status', 'property_master_id'];
	protected $primaryKey = 'image_id';
	protected $table = 'property_images';
	/*
	public function property(){
		return $this->belongsTo('App\Property');
	}*/
}
