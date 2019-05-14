<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;

class ExamineController extends Controller
{
    public function material(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status',2)->get();
    		return view('Cost.Examine.material',[
               'project' => $project,
           ]);
    	}else
    	{
			$formData['project_id'] = $request->post('project_id','');
            $formData['unit'] = $request->post('unit','');
            $formData['building'] = $request->post('building','');
            $formData['floor'] = $request->post('floor','');
            $formData['room_number'] = $request->post('room_number','');
            $data = House::select('*')
                  ->where('project_id','like','%'.$formData['project_id'].'%')
                  ->where('unit','like','%'.$formData['unit'].'%')
                  ->where('building','like','%'.$formData['building'].'%')
                  ->where('floor','like','%'.$formData['floor'].'%')
                  ->where('room_number','like','%'.$formData['room_number'].'%')
                  ->where('status','>',0)
                  ->with(['Huxing'=>function($query){
                           return $query->select('*')->get();
                        },'Project'=>function($query){
                           return $query->select('id','name')->get();
                        },'CostEstimateDetaileds'=>function($query){
                           return $query->select('*')->get();
                        },'Materials'=>function($query){
                           return $query->select('*')->get();
                        }])
                  ->orderBy('created_at','DESC')
                  ->offset(($request->page -1) * $request->limit)
                  ->limit($request->limit)
                  ->get()
                  ->toArray();
               foreach($data as $k=>$v)
               {  
                  $data[$k]['budget_price'] = 0;
                  $data[$k]['settlement_price'] = 0;
                  if($v['huxing'])
                  {
                      $data[$k]['huxing_name'] = $v['huxing']['name'];
                  }
                  if($v['project'])
                  {
                      $data[$k]['project_name'] = $v['project']['name'];
                  }
                  
                  foreach($v['cost_estimate_detaileds'] as $kk => $vv)
                  {
                     $data[$k]['budget_price'] = bcadd($data[$k]['budget_price'],$vv['total'],2);
                  }
                  foreach($v['materials'] as $kkk => $vvv)
                  {  
                     $data[$k]['settlement_price'] = bcadd(bcadd($data[$k]['settlement_price'],$vvv['artificial_price'],2),bcmul($vvv['purchase_price'],$vvv['num'],2),2);
                  }
                  $data[$k]['budget_price'] = $data[$k]['budget_price']?$data[$k]['budget_price']:'';
                  $data[$k]['settlement_price'] = $data[$k]['settlement_price']?$data[$k]['settlement_price']:'';
               }
            $total = House::select('*')
                  ->where('project_id','like','%'.$formData['project_id'].'%')
                  ->where('unit','like','%'.$formData['unit'].'%')
                  ->where('building','like','%'.$formData['building'].'%')
                  ->where('floor','like','%'.$formData['floor'].'%')
                  ->where('room_number','like','%'.$formData['room_number'].'%')
                  ->where('status','>',0)
                  ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function material_band(Request $request)
    {
    	$house = House::find($request->id);
    	if(!$house) $this->error_message('数据不存在 请刷新页面');
    	$is_examine_a = $request->is_examine_a?1:0;
    	$house->is_examine_a = $is_examine_a;
    	if($house->save())
    	{
    		$this->success_message('操作成功');
    	}else
    	{
    		$this->error_message('操作失败');
    	}
    } 
    public function material_edit(Request $request)
    {
    	$house = House::find($request->id);
    	if(!$house) $this->error_message('数据不存在 请刷新页面');
    	$house->examine_remarks_a = $request->examine_remarks_a;
    	if($house->save())
    	{
    		$this->success_message('编辑成功');
    	}else
    	{
    		$this->error_message('编辑失败');
    	}
    }

    public function material_supplier(Request $request)
    {	
    	if($request->isMethod('get'))
    	{
    		$house = House::find($request->house_id);
	    	if(!$house) die('数据不存在');
	    	return view('Cost.Examine.material_supplier',[
	    		'house' => $house
	    	]);
    	}else
		{
			$data = House::find($request->house_id);
			if(!$data)
            {
                $this->tableData(0,[],'获取成功',0);
            }
            $data = $data->Materials->toArray();
            foreach($data as $k => $v)
            {
                $data[$k]['total'] = ($v['purchase_price'] * $v['num']) + $v['artificial_price'];
            }
            $this->tableData(null,$data,'获取成功',0);
        }
	}

    public function plan(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status',2)->get();
    		return view('Cost.Examine.plan',[
               'project' => $project,
           ]);
    	}else
    	{
			$formData['project_id'] = $request->post('project_id','');
            $formData['unit'] = $request->post('unit','');
            $formData['building'] = $request->post('building','');
            $formData['floor'] = $request->post('floor','');
            $formData['room_number'] = $request->post('room_number','');
            $data = House::select('*')
                  ->where('project_id','like','%'.$formData['project_id'].'%')
                  ->where('unit','like','%'.$formData['unit'].'%')
                  ->where('building','like','%'.$formData['building'].'%')
                  ->where('floor','like','%'.$formData['floor'].'%')
                  ->where('room_number','like','%'.$formData['room_number'].'%')
                  ->where('status','>',0)
                  ->with(['Huxing'=>function($query){
                           return $query->select('*')->get();
                        },'Project'=>function($query){
                           return $query->select('id','name')->get();
                        },'CostEstimateDetaileds'=>function($query){
                           return $query->select('*')->get();
                        },'EngineeringMaterials'=>function($query){
                           return $query->select('*')->get();
                        }])
                  ->orderBy('created_at','DESC')
                  ->offset(($request->page -1) * $request->limit)
                  ->limit($request->limit)
                  ->get()
                  ->toArray();
               foreach($data as $k=>$v)
               {  
                  $data[$k]['budget_price'] = 0;
                  $data[$k]['settlement_price'] = 0;
                  if($v['huxing'])
                  {
                      $data[$k]['huxing_name'] = $v['huxing']['name'];
                  }
                  if($v['project'])
                  {
                      $data[$k]['project_name'] = $v['project']['name'];
                  }
                  
                  foreach($v['cost_estimate_detaileds'] as $kk => $vv)
                  {
                     $data[$k]['budget_price'] = bcadd($data[$k]['budget_price'],$vv['total'],2);
                  }
                  foreach($v['engineering_materials'] as $kkkk => $vvvv)
                  {  
                     $data[$k]['settlement_price'] = bcadd(bcadd(bcadd($data[$k]['settlement_price'],$vvvv['artificial_price'],2),bcmul($vvvv['purchase_price'],$vvvv['num'],2),2),$vvvv['other_price'],2);
                  }
                  $data[$k]['budget_price'] = $data[$k]['budget_price']?$data[$k]['budget_price']:'';
                  $data[$k]['settlement_price'] = $data[$k]['settlement_price']?$data[$k]['settlement_price']:'';
               }
            $total = House::select('*')
                  ->where('project_id','like','%'.$formData['project_id'].'%')
                  ->where('unit','like','%'.$formData['unit'].'%')
                  ->where('building','like','%'.$formData['building'].'%')
                  ->where('floor','like','%'.$formData['floor'].'%')
                  ->where('room_number','like','%'.$formData['room_number'].'%')
                  ->where('status','>',0)
                  ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function plan_band(Request $request)
    {
    	$house = House::find($request->id);
    	if(!$house) $this->error_message('数据不存在 请刷新页面');
    	$is_examine_b = $request->is_examine_b?1:0;
    	$house->is_examine_b = $is_examine_b;
    	if($house->save())
    	{
    		$this->success_message('操作成功');
    	}else
    	{
    		$this->error_message('操作失败');
    	}
    } 
    public function plan_edit(Request $request)
    {
    	$house = House::find($request->id);
    	if(!$house) $this->error_message('数据不存在 请刷新页面');
    	$house->examine_remarks_b = $request->examine_remarks_b;
    	if($house->save())
    	{
    		$this->success_message('编辑成功');
    	}else
    	{
    		$this->error_message('编辑失败');
    	}
    }

    public function plan_plan(Request $request)
    {	
    	$house = House::find($request->house_id);
    	if(!$house) die('数据不存在');
    	return view('Cost.Examine.plan_plan',[
    		'house' => $house
    	]);
	}
}
