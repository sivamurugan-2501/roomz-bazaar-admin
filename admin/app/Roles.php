<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //fillable fields
    protected $fillable = ['role_name', 'role_status'];
    protected $primaryKey = 'role_id';
    protected $table = 'backend_roles';
}
