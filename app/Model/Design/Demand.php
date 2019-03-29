<?php

namespace App\Model\Design;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $table = 'design_demand';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
