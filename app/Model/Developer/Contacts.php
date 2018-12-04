<?php

namespace App\Model\Developer;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'developer_contacts';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
