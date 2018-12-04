<?php

namespace App\Model\Developer;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'developer_project_appointment';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function User()
    {
    	return $this->hasOne('App\Model\Sys\User','id','user_id');
    }
    public function Feedback()
    {
        return $this->hasOne('App\Model\Developer\Feedback','appointment_id','id');
    }
}
