<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'sys_menu';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Menus()
    {
    	return $this->hasMany('App\Model\Sys\Menu','pid','id');
    }

    public function Menu()
    {
    	return $this->hasOne('APP\Model\Sys\Menu','id','pid');
    }
}
