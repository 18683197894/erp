<?php

namespace App\Model\Customer;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //ja_customer_user
    protected $table = 'customer_house_schedule';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function SysUser()
    {
    	return $this->hasOne('App\Model\Sys\User','id','sys_user_id');
    }
}
