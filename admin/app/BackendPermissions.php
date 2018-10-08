<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackendPermissions extends Model
{
	protected $primaryKey = 'permission_id';
	protected $table = 'backend_permissions';
}
