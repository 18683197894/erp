<?php

namespace App\Model\Engineering;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'engineering_house';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Huxing()
    {
    	return $this->hasOne('App\Model\Design\Huxing','id','huxing_id');
    }
    public function User()
    {
        return $this->hasOne('App\Model\Design\User','id','user_id');
    }
    public function Project()
    {
        return $this->hasOne('App\Model\Developer\Project','id','project_id');
    }
    public function OwnerSchedules()
    {
        return $this->hasMany('App\Model\Design\Schedule','house_id','id');
    }
    public function Demand()
    {
        return $this->hasOne('App\Model\Design\Demand','house_id','id');
    }
    public function Materials()
    {
        return $this->hasMany('App\Model\Design\Material','house_id','id');
    }
    public function Template()
    {
        return $this->hasOne('App\Model\Engineering\House','id','template_id');
    }

    public function EngineeringSchedules()
    {
        return $this->hasMany('App\Model\Engineering\Schedule','house_id','id');
    }
    public function EngineeringMaterials()
    {
        return $this->hasMany('App\Model\Engineering\Material','house_id','id');
    }
    public function CostEstimateDetaileds()
    {
        return $this->hasMany('App\Model\Cost\CostEstimateDetailed','house_id','id');
    }
    public function Schedules()
    {
        return $this->hasMany('App\Model\Design\Schedule','user_id','user_id');
    }
    public function Prices()
    {
        return $this->hasMany('App\Model\Finance\HousePrice','house_id','id');
    }
}
