<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'sys_user';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Department()
    {
    	return $this->hasOne('App\Model\Sys\Department','id','department_id');
    }
    public function Roles()
    {
    	return $this->belongsToMany('App\Model\Sys\PowerRole','sys_user_role','user_id','role_id');
    }
}
