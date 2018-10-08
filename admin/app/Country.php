<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	//fillable fields
	protected $fillable = ['country_name', 'country_code', 'country_status'];
	protected $primaryKey = 'country_id';
	protected $table = 'country_master';
}