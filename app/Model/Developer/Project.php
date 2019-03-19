<?php

namespace App\Model\Developer;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'developer_project';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i',
        'screening_time' => 'datetime:Y-m-d H:i'
    ];

    public function Company()
    {
    	return $this->hasOne('App\Model\Developer\Company','id','company_id');
    }

    public function Appointments()
    {
        return $this->hasMany('App\Model\Developer\Appointment','project_id','id');
    }

    public function Houses()
    {
        return $this->hasMany('App\Model\Engineering\House','project_id','id');
    }
    public function Huxings()
    {
        return $this->hasMany('App\Model\Design\Huxing','project_id','id');
    }
}
