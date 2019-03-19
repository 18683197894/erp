<?php

namespace App\Model\App;

use Illuminate\Database\Eloquent\Model;

class MsgUser extends Model
{
    protected $table = 'app_msg_user';
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at'   => 'date:Y-m-d H:i',
        'updated_at'   => 'datetime:Y-m-d H:i'
    ];

    public function Msg()
    {
    	return $this->HasOne('App\Model\App\Msg','id','msg_id');
    }
}
