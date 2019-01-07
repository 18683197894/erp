<?php

namespace App\Model\Design;

use Illuminate\Database\Eloquent\Model;

class Huxing extends Model
{
    protected $table = 'design_huxing';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Project()
    {
    	return $this->hasOne('App\Model\Developer\Project','id','project_id');
    }
}
