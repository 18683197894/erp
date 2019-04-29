<?php

namespace App\Model\Engineering;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'engineering_material';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
