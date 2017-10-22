<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	//fillable fields
	protected $fillable = ['city_name', 'state_id', 'state_status'];
	protected $primaryKey = 'city_id';
	protected $table = 'city_master';
}
