<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'sys_department';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Users()
    {
    	return $this->hasMany('App\Model\Sys\User','department_id','id');
    }
}
