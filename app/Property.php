<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //fillable fields
	protected $fillable = ['name', 'property_type_id', 'show_as', 'address', 'city_id', 'state_id', 'country_id', 'landmark', 'property_age', 'total_floors', 
						   'floor_no', 'per_square_feet', 'total_square_feet', 'carpet_area', 'usable_area', 'total_rate', 'negotiable', 'advance_deposite', 
						   'rent_per_month', 'maintenance_include', 'parking', 'gym', 'water_supply', 'garden', 'others', 'rera_number', 'property_status'];
	protected $primaryKey = 'id';
	protected $table = 'property_master';
}
