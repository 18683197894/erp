<?php

namespace App\Model\App;

use Illuminate\Database\Eloquent\Model;

class Msg extends Model
{
    protected $table = 'app_msg';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
