<?php

namespace App\Model\Design;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //业主表
    protected $table = 'design_user';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
    public function Schedules()
    {
        return $this->hasMany('App\Model\Design\Schedule','user_id','id');
    }
    public function Houses()
    {
        return $this->hasMany('App\Model\Engineering\House','user_id','id');
    }
}
