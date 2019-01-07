<?php

namespace App\Model\Supplier;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'supplier_material';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Supply()
    {
    	return $this->hasOne('App\Model\Supplier\Supply','id','supply_id');
    }
    public function Category()
    {
    	return $this->hasOne('App\Model\Supplier\Category','id','category_id');
    }
}
