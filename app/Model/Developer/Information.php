<?php

namespace App\Model\Developer;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'developer_information';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
