<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Engineering\House;
use App\Model\Design\Schedule;
use App\Model\Design\User;
use App\Model\Design\Demand;
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
    				->where('status','>=',0)
    				->where('user_id',null)
    				->get();
            $user = User::where('status','>=',0)
                    ->get();
    		return view('Design.Owner.owner',[
                'house'=>$house,
                'user' => $user,
                'style' => array('简欧','简美','港式','美式','欧式','混搭','田园','现代','新古典','东南亚','日式','宜家','北欧','简约','韩式','地中海','中式','法式','工业风','新中式','清水房','其他')
                ]);
    	}else
    	{
            $username = $request->post('name','');
    		$data = House::select('engineering_house.id','engineering_house.user_id','design_user.id as user_id','design_user.username','design_user.email','design_user.sex','design_user.phone','design_user.wechat_name','engineering_house.remarks','engineering_house.total')
    				->join('design_user',function($join){
    					return $join->on('engineering_house.user_id','=','design_user.id');
    				})
                    ->with('Demand')
    				->where('engineering_house.user_id','!=','null')
                    ->where('design_user.username','like','%'.$username.'%')
    				->offset(($request->page - 1) * $request->limit)
    				->limit($request->limit)
    				->get();
            foreach($data as $k => $v)
            {
                $data[$k]->money  = 0;
                $tmp = Schedule::where('user_id',$v->user_id)->get();
                if($tmp)
                {
                    foreach($tmp as $val)
                    {
                        $data[$k]->money += $val->money;
                    }
                }
                $data[$k]->money = number_format($data[$k]->money,2,'.','');

            }
    		$total = House::select('engineering_house.user_id','design_user.id as user_id','design_user.username','design_user.email','design_user.sex','design_user.phone','design_user.wechat_name','design_user.remarks','design_user.total')
    				->join('design_user',function($join){
    					return $join->on('engineering_house.user_id','=','design_user.id');
    				})
    				->where('engineering_house.user_id','!=','null')
                    ->where('design_user.username','like','%'.$username.'%')
    				->count();
    		foreach ($data as $key => $value) 
    		{
    			$data[$key]->sex_name = $value->sex == 1 ? '男':'女';
    		}
    		$this->tableData($total,$data,'获取成功',0);

    	}
    }
    public function owner_add(Request $request)
    {
        $data = $request->except('_token');
        if(!User::find($data['user_id']))
        {
            $this->error_message('客户不存在');
        }
        $house = House::find($data['house_id']);
        if($house)
        {
            $house->remarks = $data['remarks'];
            $house->total = $data['total'];
            $house->user_id = $data['user_id'];
            $house->save();
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('房屋不存在');
        }
    }
    public function owner_edit(Request $request)
    {
        $data = $request->except('_token');
        House::where('id',$data['id'])->update($data);
        $this->success_message('修改成功');
    }
    public function owner_del(Request $request)
    {
        $id = $request->id;
        $model = House::find($id);
        if($model)
        {
            House::where('id',$id)->update(['user_id'=>null,'total'=>null,'remarks'=>null]);
            Schedule::where('user_id',$model->user_id)->delete();
        }
        $this->success_message('删除成功');
    }
    public function schedule(Request $request)
    {   
        if($request->isMethod('get'))
        {   
            $user = User::find($request->user_id);
            if(!$user)
            {
                die('数据不存在');
            } 
            return view('Design.Owner.schedule',[
                'user'=>$user
            ]);
        }else
        {
            $data = Schedule::where('user_id',$request->user_id)
                            ->where('status','>',0)
                            ->orderBy('time')
                            ->offset(($request->page -1) * $request->limit)
                            ->limit($request->limit)
                            ->get()
                            ->toArray();
             $total = Schedule::where('user_id',$request->user_id)
                            ->where('status','>',0)
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
        
    }

    public function schedule_add(Request $request)
    {
        $data = $request->except('_token');
        // if(date('Y-m-d',time()) < $data['time'])
        // {
        //     $this->error_message('请从新选择时间');
        // }
        if(Schedule::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->success_message('新增失败');
        }
    }

    public function schedule_edit(Request $request)
    {
        $data = $request->except('_token');
        // if(date('Y-m-d',time()) < $data['time'])
        // {
        //     $this->error_message('请从新选择时间');
        // }

        $model = Schedule::where('id',$data['id'])->where('status','>',0)->first();
        if(!$model)
        {
            $this->error_message('数据不存在');
        }
        Schedule::where('id',$data['id'])->update($data);
        $this->success_message('修改成功');
    }

    public function schedule_del(Request $request)
    {
        $id = $request->id;
        Schedule::where('id',$id)->delete();
        $this->success_message('删除成功');
    }

    public function demand_edit(Request $request)
    {
        $data = $request->except('_token');
        $model = Demand::where('house_id',$data['house_id'])->first();
        if($model)
        {
            $model->arrangement = $data['arrangement'];
            $model->style = $data['style'];
            $model->like = $data['like'];
            $model->demand = $data['demand'];
            if($model->save())
            {
                $this->success_message('更新成功');
            }else
            {
                $this->error_message('更新失败');
            }
        }else
        {
            $res = Demand::create($data);
            if($res)
            {
                $this->success_message('更新成功');
            }else
            {
                $this->error_message('更新失败');
            }
        }
    }
}
