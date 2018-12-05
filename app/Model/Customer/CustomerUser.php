<?php

namespace App\Model\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerUser extends Model
{
    //ja_customer_user
    protected $table = 'customer_user';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];
}
