<?php

namespace App\Model\Finance;

use Illuminate\Database\Eloquent\Model;

class HousePrice extends Model
{
    protected $table = 'finance_house_price';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function Department()
    {
    	return $this->hasOne('App\Model\Sys\Department','id','department_id');
    }
    public function House()
    {
    	return $this->hasOne('App\Model\Engineering\House','id','house_id');
    }
    public function Project()
    {
        return $this->hasOne('App\Model\Developer\Project','id','project_id');
    }
}
