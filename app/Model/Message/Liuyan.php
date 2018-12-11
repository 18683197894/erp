<?php

namespace App\Model\Message;

use Illuminate\Database\Eloquent\Model;

class Liuyan extends Model
{
    protected $table = 'message_liuyan';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function User()
    {
    	return $this->hasOne('App\Model\Sys\User','id','user_id');
    }
}
