<?php

namespace App\Http\Controllers\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Engineering\House;
use App\Model\Design\User;
use App\Model\Design\UserHouse;

class OwnerController extends Controller
{
    public function owner(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$house = House::select('id','unit','building','floor','room_number','project_id')
    				->with(['Project'=>function($query){
    					return $query->select('id','name');
    				}])
    				->where('user_id',null)
    				->where('status','>=',0)
    				->get();
    		return view('Sale.Owner.owner',[
                'house'=>$house,
                'style' => array('简欧','简美','港式','美式','欧式','混搭','田园','现代','新古典','东南亚','日式','宜家','北欧','简约','韩式','地中海','中式','法式','工业风','新中式','清水房','其他')
                ]);
    	}else
    	{	
    		// $data = House::select('engineering_house.id','engineering_house.user_id','design_user.id as user_id','design_user.username','design_user.email','design_user.sex','design_user.phone','design_user.wechat_name','design_user.remarks','design_user.total')
            //          ->join('design_user',function($join){
            //              return $join->on('engineering_house.user_id','=','design_user.id');
            //          })
            //          ->where('engineering_house.user_id','!=','null')
            //          ->where('design_user.username','like','%'.$username.'%')
            //          ->offset(($request->page - 1) * $request->limit)
            //          ->limit($request->limit)
            //          ->get();
            //  $total = House::select('engineering_house.user_id','design_user.id as user_id','design_user.username','design_user.email','design_user.sex','design_user.phone','design_user.wechat_name','design_user.remarks','design_user.total')
            //           ->join('design_user',function($join){
            //               return $join->on('engineering_house.user_id','=','design_user.id');
            //           })
            //           ->where('engineering_house.user_id','!=','null')
            //           ->where('design_user.username','like','%'.$username.'%')
            //           ->count();
    		$username = $request->post('name','');
    		$data = User::select('*')
    					->with('Houses')
    					->where('status','>',0)
    					->where('username','like','%'.$username.'%')
    					->get();
            
    		$total = User::where('status','>',0)
    					->where('username','like','%'.$username.'%')
    					->count();
    		foreach ($data as $key => $value) 
    		{
    			$data[$key]->sex_name = $value->sex == 1 ? '男':'女';
    			$data[$key]->is_intention = $value->is_intention?'是':'否';
    			$data[$key]->is_house_about = $value->is_house_about?'是':'否';
    			$data[$key]->is_purchase_about = $value->is_purchase_about?'是':'否';
    			$data[$key]->is_hardcover = $value->Houses?'是':'否';
    		}
    		$this->tableData($total,$data,'获取成功',0);

    	}
    }
    public function owner_add(Request $request)
    {
        $data = $request->except('_token','house_id');
        $data['is_intention'] = $request->is_intention == 'on'?1:0;
        $data['is_house_about'] = $request->is_house_about == 'on'?1:0;
        $data['is_purchase_about'] = $request->is_purchase_about == 'on'?1:0;
        $user = User::where('username',$data['username'])
        			->where('phone',$data['phone'])
        			->first();
     	if($user)
     	{
     		$this->error_message('客户已存在！');
     	}
     	if($request->house_id)
     	{
     		$house = House::where('id',$request->house_id)->first();
	     	if(!$house)
	     	{
	     		$this->error_message('房屋不存在');
	     	}
	     	if(!empty($house->user_id))
	     	{
	     		$this->error_message('当前房屋已被绑定！');
	     	}
     	}
        $userRes =  User::create($data);
        if(!$userRes)
        {	
        	if($request->house_id)
        	{
        		$house->user_id = $userRes->id;
        		$house->save();
        	}
            $this->error_message('客户创建失败');
        }
        $this->success_message('新增成功');

    }

    public function owner_edit(Request $request)
    {
        $data = $request->except('_token');
        $model = User::find($data['id']);
        if(!$model)
        {
            $this->error_message('数据不存在');
        }

        $model->username = $data['username'];
        $model->sex = $data['sex'];
        $model->phone = $data['phone'];
        $model->email = $data['email'];
        $model->wechat_name = $data['wechat_name'];
        $model->total = $data['total'];
        $model->remarks = $data['remarks'];
        $model->save();
        $this->success_message('修改成功');
    }

    public function owner_del(Request $request)
    {
        $id = $request->id;
        $model = User::find($id);
        if($model)
        {
            House::where('user_id',$id)->update(['user_id'=>null]);
            Schedule::where('user_id',$model->id)->delete();
            User::destroy($id);
        }
        $this->success_message('删除成功');
    }
}
