<?php

namespace App\Model\Cost;

use Illuminate\Database\Eloquent\Model;

class CostEstimateDetailed extends Model
{
    protected $table = 'cost_estimate_detailed';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
