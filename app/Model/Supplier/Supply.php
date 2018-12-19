<?php

namespace App\Model\Supplier;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = 'supplier_supply';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
