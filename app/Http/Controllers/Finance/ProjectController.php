<?php

namespace App\Http\Controllers\Finance;
use App\Model\Engineering\House;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Sys\Department;
use App\Model\Finance\HousePrice;
use App\Model\Finance\ProjectRoyalty;
class ProjectController extends Controller
{
    public function project(Request $request,$department_id=null)
    {   
    	if($request->isMethod('get'))
    	{	
    		$department = Department::find($department_id);
    		if(!$department) die('数据不存在');
    		return view('Finance.Project.project',[
    			'department' => $department
    		]);
    	}else
    	{   
             $housePrices = HousePrice::select('*')
                        ->where('price_cost',0)
                        ->get();

            $zhichu = 0;
            foreach($housePrices as $key => $value)
            {
                $zhichu  = bcadd($zhichu,$value->price_money,2);
            } 
            $department = Department::find($request->department_id);
    		$data = Project::select('*')
    			->where('status',2)
                ->with(['HousePrices'=>function($query) use($request){
                    return $query->select('*')
                            ->where('department_id','like','%'.$request->department_id.'%')
                            ->with('House')
                            ->orderBy('payment_time','DESC')
                            ->orderBy('created_at','DESC')
                            ->get();
                }])
    			->offset(($request->page - 1) * $request->limit)
    			->limit($request->limit)
    			->get();
            foreach($data as $k => $v)
            {   
                $data[$k]->department_name = $department->name;
                if(isset($v->HousePrices[0]))
                {
                    $data[$k]->price_cost_name = $v->HousePrices[0]->price_cost?'收入':'支出';
                    $data[$k]->price_purpose = $v->HousePrices[0]->price_purpose;
                    $data[$k]->price_money = $v->HousePrices[0]->price_money;
                    $data[$k]->price_name = $v->HousePrices[0]->price_name;
                    $data[$k]->payment_time = $v->HousePrices[0]->payment_time;
                    $data[$k]->remarks = $v->HousePrices[0]->remarks;
                    $data[$k]->house = $v->HousePrices[0]->House->building.'栋'.$v->HousePrices[0]->House->unit.'单元'.$v->HousePrices[0]->House->building.'层'.$v->HousePrices[0]->House->floor.'号';
                }

                $data[$k]->total_should = 0;
                $data[$k]->total_money = 0;
                $data[$k]->total_zhichu = 0;
                foreach($v->HousePrices as $kk => $vv)
                {   
                    if($vv->price_cost == 1)
                    {
                        $data[$k]->total_should = bcadd($data[$k]->total_should,$vv->price_should,2);
                        $data[$k]->total_money = bcadd($data[$k]->total_money,$vv->price_money,2);
                    }else
                    {
                         $data[$k]->total_zhichu = bcadd($data[$k]->total_zhichu,$vv->price_money,2);
                    }
                   
                }
                $data[$k]->price_surplus = bcsub($v->price_budget,$zhichu,2);

                $data[$k]->total_should = $data[$k]->total_should?$data[$k]->total_should:'';
                $data[$k]->total_money = $data[$k]->total_money?$data[$k]->total_money:'';
                $data[$k]->total_zhichu = $data[$k]->total_zhichu?$data[$k]->total_zhichu:'';

            }
            $total = Project::select('*')
                    ->where('status',2)
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}

    }
    public function price(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
            $house = House::select('id','unit','building','floor','room_number','project_id')
                    ->with(['Project'=>function($query){
                        return $query->select('id','name');
                    }])
                    ->where('status','>=',0)
                    ->where('project_id',$request->project_id)
                    ->get();
    		$project = Project::find($request->project_id);
    		$department = Department::find($request->department_id);
    		if(!$project || !$department) die('数据不存在');
    		return view('Finance.Project.price',[
    			'department' => $department,
    			'project' => $project,
                'house' => $house
    		]);
    	}else
    	{   
            $project_id = $request->project_id;
            $department_id = $request->department_id;
            $data = HousePrice::select('*')
                    ->where('project_id',$project_id)
                    ->where('department_id',$department_id)
                    ->where('price_cost','like','%'.$request->get('price_cost','').'%')
                    ->whereHas('House',function($query) use($request){
                        $query->where('building','like','%'.$request->get('building','').'%')
                        ->where('unit','like','%'.$request->get('unit','').'%')
                        ->where('floor','like','%'.$request->get('floor','').'%')
                        ->where('room_number','like','%'.$request->get('room_number','').'%');
                          
                    })
                    ->with(['Department'=>function($query){
                        return $query->select('*');
                    },'House'=>function($query){
                        return $query->select('*');
                    }])
                    ->orderBy('payment_time','DESC')
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page - 1) * $request->limit)
                    ->limit($request->limit)
                    ->get();
            foreach($data as $k => $v)
            {   
                $data[$k]->price_cost_name = $v->price_cost?'收入':'支出';
                $data[$k]->department_name = $v->department->name;
                $data[$k]->unit = $v->house->unit;
                $data[$k]->floor = $v->house->floor;
                $data[$k]->room_number = $v->house->room_number;
                $data[$k]->building = $v->house->building;
                $data[$k]->price_difference = bcsub($v->price_money,$v->price_should,2);
                $data[$k]->last_time = round((strtotime($v->payment_time) - strtotime($v->propose_time)) / 3600 / 24).'天';
                foreach($v->House->Schedules as $kk => $vv)
                {
                    $data[$k]->price_design = bcadd($data[$k]->price_design,$vv->money,2);
                }
            }

            $total = HousePrice::select('*')
                    ->where('project_id',$project_id)
                    ->where('department_id',$department_id)
                    ->where('price_cost','like','%'.$request->get('price_cost','').'%')
                    ->whereHas('House',function($query) use($request){
                        $query->where('building','like','%'.$request->get('building','').'%')
                        ->where('unit','like','%'.$request->get('unit','').'%')
                        ->where('floor','like','%'.$request->get('floor','').'%')
                        ->where('room_number','like','%'.$request->get('room_number','').'%');
                          
                    })
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }
    public function price_add(Request $request)
    {
        $data = $request->except('_token');
        $house = House::find($data['house_id']);
        $project = Project::find($data['project_id']);
        $department = Department::find($data['department_id']);
        if(!$house || !$project || !$department)
        {
            $this->error_message('数据不存在');
        }
        if(HousePrice::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('新增失败');
        }
    }

    public function price_edit(Request $request)
    {
        $data = $request->except('_token');
        HousePrice::where('id',$data['id'])->update($data);
        $this->success_message('修改成功');
    }

    public function price_del(Request $request)
    {
        HousePrice::where('id',$request->id)->delete();
        $this->success_message('删除成功');
    }
    public function income(Request $request)
    {
        if($request->isMethod('get'))
        {   
            $data = HousePrice::select('*')
                    ->where('project_id',$request->project_id)
                    ->where('department_id',$request->department_id)
                    ->where('price_cost',1)
                    ->get();
            $price_project = 0;
            foreach($data as $k => $v)
            {
                $price_project = bcadd($price_project,$v->price_money,2);
            }
            $project = Project::find($request->project_id);
            $department = Department::find($request->department_id);
            return view('Finance.Project.income',[
                'project' => $project,
                'department' => $department,
                'price_project' => $price_project
            ]);
        }else
        {   
            $department = Department::find($request->department_id);
            $data = ProjectRoyalty::select('*')
                    ->where('project_id',$request->project_id)
                    ->where('department_id',$request->department_id)
                    ->orderBy('created_at','DESC')
                    ->get();
            foreach($data as $k => $v)
            {
                $data[$k]->department_name = $department->name;
            }
            $total = ProjectRoyalty::select('*')
                    ->where('project_id',$request->project_id)
                    ->where('department_id',$request->department_id)
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
    }

    public function income_add(Request $request)
    {
        $data = $request->except('_token');
        $department = Department::find($request->department_id);
        $project = Project::find($data['project_id']);
        if(!$department || !$project)
        {
            $this->error_message('数据不存在');
        }
        if(ProjectRoyalty::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('新增失败');
        }
    }

    public function income_edit(Request $request)
    {
        $data = $request->except('_token');
        ProjectRoyalty::where('id',$data['id'])->update($data);
        $this->success_message('修改成功');
    }

    public function income_del(Request $request)
    {
        ProjectRoyalty::where('id',$request->id)->delete();
        $this->success_message('删除成功');
    }
}
