<?php

namespace App\Http\Controllers\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message\Liuyan;
class MessageController extends Controller
{
    public function liuyan_add(Request $request)
    {
    	$data['content'] = $request->content;
    	$data['ip'] = \session('user')['last_ip'];
    	$data['user_id'] = \session('user')['id'];
    	$res = Liuyan::create($data);
    	if($res)
    	{	
    		$data = Liuyan::where('id',$res->id)
    				->with(['User'=>function($query){
    					return $query->select('id','username','head_portrait');
    				}])
    				->first()->toArray();
    		$this->success_message('留言成功',$data);
    	}else
    	{
    		$this->error_message('留言失败');
    	}
    }

    public function liuyan(Request $request)
    {
    	if($request->isMethod('get'))
    	{

    	}else
    	{
    		$data = Liuyan::with(['User'=>function($query){
    					return $query->select('id','username','head_portrait');
    				}])
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * 8)
		    		->limit(8)
		    		->paginate(8)
		    		->toArray();
		    foreach($data['data'] as $k => $v)
		    {
		    	if(!$v['user']['head_portrait'])
		    	{
		    		$data['data'][$k]['user']['head_portrait'] = asset(env('USER_HEAD_PORTRAIT')) ;
		    	}else
		    	{
		    		$data['data'][$k]['user']['head_portrait'] = asset($v['user']['head_portrait']);
		    	}
		    	$time = time() - $v['created_at'];
		    	if($time <= 60)
		    	{
		    		$data['data'][$k]['time'] = $time.'秒前';
		    	}else if($time >=60  && $time < 3600)
		    	{
		    		$data['data'][$k]['time'] = floor($time / 60).'分钟前';
		    	}else if($time >=3600  && $time < 86400)
		    	{
		    		$data['data'][$k]['time'] = floor($time / 3600).'小时前';
		    	}else if($time >=86400)
		    	{
		    		$data['data'][$k]['time'] = floor($time / 86400).'天前';
		    	}
		    }
    		$this->tableData($data['total'],$data['data'],'获取成功',0,$data['last_page']);
    	}
    }
}
