<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackendUsers extends Model
{
	// fillable fields
	protected $fillable = ['user_name', 'user_email', 'user_activation_key', 'user_password', 'user_password_reset_key', 'require_password_change', 'user_status'];
	protected $primaryKey = 'user_id';
	protected $table = 'backend_users';
}
