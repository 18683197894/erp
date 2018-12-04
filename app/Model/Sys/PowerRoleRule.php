<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class PowerRoleRule extends Model
{
    protected $table = 'sys_power_role_rule';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
