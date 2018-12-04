<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class PowerCate extends Model
{
    protected $table = 'sys_power_cate';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Rules()
    {
    	return $this->hasMany('App\Model\Sys\PowerRule','cate_id','id');
    }
}
