<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\App\Msg;
use App\Model\App\MsgUser;
class MessageController extends Controller
{
    public function message(Request $request)
    {   
    	if($request->isMethod('get'))
    	{   
    		return view('App.Message.message');
    	}else
    	{   
            $uid = \session('user')['id'];
    		switch($request->type)
            {
                case 0 :
                    $data = MsgUser::select('app_msg_user.*','app_msg.id as msg_id','app_msg.title','app_msg.type','app_msg.created_at as msg_created_at','sys_user.username')
                        ->join('app_msg',function($join){
                            $join->on('app_msg_user.msg_id','=','app_msg.id');
                        })
                        ->join('sys_user',function($join){
                            $join->on('app_msg.created_uid','=','sys_user.id');
                        })
                        ->where('app_msg_user.user_id',$uid)
                        ->where('app_msg_user.is_delete','!=',1)
                        ->orderBy('app_msg.created_at','DESC')
                        ->offset(($request->page - 1) * $request->limit)
                        ->limit($request->limit)
                        ->get();
                    $count = MsgUser::select('*')
                        ->where('user_id',$uid)
                        ->where('is_delete','!=',1)
                        ->count();
                    $this->tableData($count,$data,'获取成功',0);

                break;
                case 1 :
                    $data = MsgUser::select('app_msg_user.*','app_msg.id as msg_id','app_msg.title','app_msg.type','app_msg.created_at as msg_created_at','app_msg.created_uid','sys_user.username')
                        ->join('app_msg',function($join){
                            $join->on('app_msg_user.msg_id','=','app_msg.id')
                                ->where('app_msg.type',1);
                                
                        })
                        ->join('sys_user',function($join){
                            $join->on('app_msg.created_uid','=','sys_user.id');
                        })
                        ->where('app_msg_user.user_id',$uid)
                        ->where('app_msg_user.is_delete','!=',1)
                        ->orderBy('app_msg.created_at','DESC')
                        ->offset(($request->page - 1) * $request->limit)
                        ->limit($request->limit)
                        ->get();
                    $count = MsgUser::select('*')
                        ->where('type',1)
                        ->where('user_id',$uid)
                        ->where('is_delete','!=',1)
                        ->count();
                    $this->tableData($count,$data,'获取成功',0);

                break;
                case 2 :
                    $data = MsgUser::select('app_msg_user.*','app_msg.id as msg_id','app_msg.title','app_msg.type','app_msg.created_at as msg_created_at','app_msg.created_uid','sys_user.username')
                        ->join('app_msg',function($join){
                            $join->on('app_msg_user.msg_id','=','app_msg.id')
                                ->where('app_msg.type',2);
                                
                        })
                        ->join('sys_user',function($join){
                            $join->on('app_msg.created_uid','=','sys_user.id');
                        })
                        ->where('app_msg_user.user_id',$uid)
                        ->where('app_msg_user.is_delete','!=',1)
                        ->orderBy('app_msg.created_at','DESC')
                        ->offset(($request->page - 1) * $request->limit)
                        ->limit($request->limit)
                        ->get();
                    $count = MsgUser::select('*')
                        ->where('type',2)
                        ->where('user_id',$uid)
                        ->where('is_delete','!=',1)
                        ->count();
                    $this->tableData($count,$data,'获取成功',0);

                break;
                case 3 :
                    $data = MsgUser::select('app_msg_user.*','app_msg.id as msg_id','app_msg.title','app_msg.type','app_msg.created_at as msg_created_at','app_msg.created_uid','sys_user.username')
                        ->join('app_msg',function($join){
                            $join->on('app_msg_user.msg_id','=','app_msg.id')
                                ->where('app_msg.type',3);
                                
                        })
                        ->join('sys_user',function($join){
                            $join->on('app_msg.created_uid','=','sys_user.id');
                        })
                        ->where('app_msg_user.user_id',$uid)
                        ->where('app_msg_user.is_delete','!=',1)
                        ->orderBy('app_msg.created_at','DESC')
                        ->offset(($request->page - 1) * $request->limit)
                        ->limit($request->limit)
                        ->get();
                    $count = MsgUser::select('*')
                        ->where('type',3)
                        ->where('user_id',$uid)
                        ->where('is_delete','!=',1)
                        ->count();
                    $this->tableData($count,$data,'获取成功',0);
                break;
                default :
                    $this->tableData(0,[],'获取失败',201);
            }
    	}
    }
    public function unread(Request $request)
    {
        $data['letter'] = MsgUser::where('is_read',0)->where('type',1)->where('is_delete',0)->count();
        $data['notice'] = MsgUser::where('is_read',0)->where('type',2)->where('is_delete',0)->count();
        $data['sys']   = MsgUser::where('is_read',0)->where('type',3)->where('is_delete',0)->count();
        $this->success_message('获取成功',$data);

    }
    public function message_detail(Request $request)
    {
        $model = MsgUser::find($request->id);
        if(!$model || $model->Msg->is_delete == 1)
        {
            return back()->with(['error_message'=>'数据不存在']);
        }
        if($model->is_read != 1)
        {
            $model->is_read = 1;
            $model->read_at = time();
            $model->save();
        }
        return view('App.Message.dateil',['model'=>$model]);
    }

    public function message_edit(Request $request){
        $uid = \session('user')['id'];
        switch($request->type)
        {
            case 'all' :
                switch($request->class)
                {
                    case 'allRead':
                        MsgUser::where('user_id',$uid)
                                ->where('is_delete','!=',1)
                                ->where('is_read','!=',1)
                                ->update(['is_read'=>1,'read_at'=>time()]);
                        $this->success_message('操作成功');
                    break;
                }
            break;
            case 'letter' :
                switch($request->class)
                {
                    case 'allRead':
                        MsgUser::where('user_id',$uid)
                                ->where('is_delete','!=',1)
                                ->where('type',1)
                                ->where('is_read','!=',1)
                                ->update(['is_read'=>1,'read_at'=>time()]);
                        $this->success_message('操作成功');
                    break;
                }
            break;
            case 'notice' :
                switch($request->class)
                {
                    case 'allRead':
                        MsgUser::where('user_id',$uid)
                                ->where('is_delete','!=',1)
                                ->where('type',2)
                                ->where('is_read','!=',1)
                                ->update(['is_read'=>1,'read_at'=>time()]);
                        $this->success_message('操作成功');
                    break;
                }
            break;
            case 'sys' :
                switch($request->class)
                {
                    case 'allRead':
                        MsgUser::where('user_id',$uid)
                                ->where('is_delete','!=',1)
                                ->where('type',3)
                                ->where('is_read','!=',1)
                                ->update(['is_read'=>1,'read_at'=>time()]);
                        $this->success_message('操作成功');
                    break;
                }
            break;
            case 'public' :
                switch($request->class)
                {
                    case 'Read':
                        MsgUser::whereIn('id',$request->data)
                                ->update(['is_read'=>1,'read_at'=>time()]);
                        $this->success_message('操作成功');
                    break;

                    case "Del" :
                        MsgUser::whereIn('id',$request->data)
                            ->where('is_compel','0')
                            ->where('type',1)
                            ->update(['is_delete'=>1,'delete_at'=>time(),'delete_uid'=>\Session()->get('user')['id']]);
                        $this->success_message('操作成功');
                    break;
                }
            break;
            default :
                $this->error_message('操作失败');
        }
    }
}
