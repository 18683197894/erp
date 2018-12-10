<?php

namespace App\Model\Engineering;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $table = 'engineering_demand';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
