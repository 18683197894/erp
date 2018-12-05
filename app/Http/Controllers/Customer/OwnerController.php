<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Customer\CustomerUser as User;
use App\Model\Engineering\House;

class OwnerController extends Controller
{
    public function owner(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
	    	$house = House::where('status','>',0)
				->where('user_id',null)
				->orderBy('project_id','DESC')
				->orderBy('unit')
				->orderBy('building')
				->orderBy('floor')
				->orderBy('room_number')
				->get();
    		return view('Customer.Owner.owner',[
    			'house'=>$house
    		]);
    	}else
    	{	
    		$name = $request->post('name',false)?$request->name:'';
    		$data = User::where('username','like','%'.$name.'%')
                    ->where('status','>',0)
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
    		$total = User::where('username','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function owner_add(Request $request)
    {
    	$data = $request->except('_token','house_id');

    	if(User::where('phone',$request->phone)->first())
    	{
    		$this->error_message('手机号已存在');
    	}
    	if(!empty($request->post('email',null)))
    	{
		    if(User::where('email',$request->email)->first())
	    	{
	    		$this->error_message('邮箱已存在');
	    	}
    	}
    	$res = User::create($data);
    	if($res)
    	{	
    		if($request->post('house_id'))
    		{
    			House::where('id',$request->house_id)->where('user_id',null)->where('status','>',0)->update(array('user_id'=>$res->id));
    		}
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }

    public function owner_edit(Request $request)
    {	
    	$data = $request->except('_token');
    	$model = User::find($data['id']);
    	if(!$model)
    	{
    		$this->error_message('数据不存在');
    	}

    	$phone = User::where('phone',$request->phone)->first();
    	if($phone && $phone->id != $model->id)
    	{
    		$this->error_message('手机号已存在');
    	}
    	if(!empty($request->post('email',null)))
    	{	
    		$email = User::where('email',$request->email)->first();
		    if($email && $email->id != $model->id)
	    	{
	    		$this->error_message('邮箱已存在');
	    	}
    	}

    	User::where('id',$data['id'])->update($data);
    	$this->success_message('修改成功');

    }

    public function owner_del(Request $request)
    {
    	$id = $request->id;
    	if(House::where('user_id',$id)->where('status','>',0)->get()->count() > 0)
    	{
    		$this->error_message('已禁止删除');
    	}
    	User::destroy($id);
    	$this->success_message('删除成功');
    }

    public function house(Request $request)
    {
		if($request->isMethod('get'))
        {      
            $urls = parse_url(\url()->previous());
            $user = User::find($request->user_id);
            $house = House::where('status','>',0)
				->where('user_id',null)
				->orderBy('project_id','DESC')
				->orderBy('unit')
				->orderBy('building')
				->orderBy('floor')
				->orderBy('room_number')
				->get();
            if(!$user)
            {
                return back();
            }
            return view('Customer.Owner.house',[
            	'user' => $user,
            	'house' => $house,
                'title' => $user->username,
                'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $data = House::where('user_id',$request->user_id)
                    ->where('status','>',0)
                    ->with('Huxing')
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            $total = House::where('user_id',$request->user_id)
                            ->where('status','>',0)
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
    }

    public function house_add(Request $request)
    {
    	$house_id = $request->house_id;
    	$user_id = $request->user_id;
    	
    	$model = House::where('id',$request->house_id)->where('user_id',null)->where('status','>',0)->first();
    	if(!$model)
    	{
    		$this->error_message('数据不存在');
    	}
    	if(!User::find($user_id))
    	{
    		$this->error_message('数据不存在');
    	}
    	$model->user_id = $user_id;
    	if($request->post('total',false))
    	{
    		$model->total = $request->total;
    	}
    	$model->save();
    	$this->success_message('新增成功');
    }

    public function house_edit(Request $request)
    {	
    	$house_id = $request->house_id;
    	$total = $request->total;
    	$model = House::where('id',$house_id)->where('status','>',0)->where('user_id',$request->user_id)->first();
    	if(!$model)
    	{
    		$this->error_message('数据不存在');
    	}

    	$model->total = $total;
    	$model->save();
    	$this->success_message('修改成功');
    }
}
