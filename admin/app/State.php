<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //fillable fields
    protected $fillable = ['state_name', 'country_code', 'state_code', 'state_status'];
    protected $primaryKey = 'state_id';
    protected $table = 'state_master';
}
