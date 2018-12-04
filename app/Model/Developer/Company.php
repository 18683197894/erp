<?php

namespace App\Model\Developer;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'developer_company';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Projects()
    {
    	return $this->hasMany('App\Model\Developer\Project','company_id','id');
    }
}
