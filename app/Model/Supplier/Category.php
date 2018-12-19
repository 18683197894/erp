<?php

namespace App\Model\Supplier;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'supplier_category';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
