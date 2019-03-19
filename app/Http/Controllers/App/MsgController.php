<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\User;
use App\Model\App\Msg;
use App\Model\App\MsgUser;
class MsgController extends Controller
{
    public function msg_letter(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$users = User::select('id','username')->where('status','>',0)->get();
    		return view('App.Msg.letter',['users'=>$users]);
    	}else
    	{	
    		$data['content'] = $request->content;
    		$data['title'] = $request->title;
    		$data['type'] = 1;
    		$data['created_uid'] = \session('user')['id'];
    		$msg = Msg::create($data);
    		
    		if(!$msg) $this->error_success('发送失败');
    		$msg_user = MsgUser::create(['msg_id'=>$msg->id,'user_id'=>$request->user_id]);
    		if(!$msg_user)
    		{
    			Msg::delete($msg->id);
    		}
    		$this->success_message('发送成功');
    	}
    }
}
