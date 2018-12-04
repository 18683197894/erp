<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'sys_user_role';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
