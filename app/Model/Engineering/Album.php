<?php

namespace App\Model\Engineering;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'engineering_album';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Schedule()
    {
    	return $this->hasOne('App\Model\Engineering\Schedule','id','schedule_id');
    }
}
