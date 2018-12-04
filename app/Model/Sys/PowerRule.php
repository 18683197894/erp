<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class PowerRule extends Model
{
    protected $table = 'sys_power_rule';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Cate()
    {
    	return $this->hasOne('App\Model\Sys\PowerCate','id','cate_id');
    }
}
