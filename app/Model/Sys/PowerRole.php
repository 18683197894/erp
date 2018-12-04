<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class PowerRole extends Model
{
    protected $table = 'sys_power_role';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Rules()
    {
    	return $this->belongsToMany('App\Model\Sys\PowerRule','sys_power_role_rule','role_id','rule_id');
    }
}
