<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackendUsers extends Model
{
	// fillable fields
	protected $fillable = ['name', 'email', 'password', 'user_activation_key', 'user_password_reset_key', 'require_password_change', 'role_id', 'user_status'];
	protected $primaryKey = 'id';
	protected $table = 'users';
}
