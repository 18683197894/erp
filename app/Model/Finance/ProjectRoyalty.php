<?php

namespace App\Model\Finance;

use Illuminate\Database\Eloquent\Model;

class ProjectRoyalty extends Model
{
    protected $table = 'finance_project_royalty';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
    public function Department()
    {
    	return $this->hasOne('App\Model\Sys\Department','id','department_id');
    }
    public function Project()
    {
    	return $this->hasOne('App\Model\Engineering\Project','id','project_id');
    }
}
