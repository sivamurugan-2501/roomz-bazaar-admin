<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyTypeMaster extends Model
{
    //fillable fields
	protected $fillable = ['type_name', 'type_status'];
	protected $primaryKey = 'type_id';
	protected $table = 'property_type_master';
}
