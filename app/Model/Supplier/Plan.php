<?php

namespace App\Model\Supplier;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'supplier_plan';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Project()
    {
    	return $this->hasOne('App\Model\Developer\Project','id','project_id');
    }
    public function Material()
    {
    	return $this->hasOne('App\Model\Supplier\Material','id','material_id');
    }
}
