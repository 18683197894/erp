<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Supplier\Material;
use App\Model\Supplier\Plan;

class PlanController extends Controller
{
    public function plan(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$material = Material::where('status','>',0)->get();
    		$project = Project::where('status',2)->get();
    		return view('Supplier.Plan.plan',[
    			'project' => $project,
    			'material' => $material
    		]);
    	}else
    	{
    		$data = Plan::select('*')
    				->with(['Project'=>function($query){
    					return $query->select('id','name')->get();
    				}])
    				->orderBy('created_at','DESC')
    				->offset(($request->offset - 1) * $request->limit)
    				->limit($request->limit)
    				->get();
    		foreach($data as $k => $v)
    		{
    			$data[$k]->project_name = $v->Project->name;
    			$data[$k]->total = bcmul($v->univalent,$v->num,2); 
    		}
    		$total = Plan::select('*')
    				->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}			
    }

    public function plan_add(Request $request)
    {
    	$data = $request->post('data');
    	if(!Project::find($data['project_id']))
    	{
    		$this->error_message('项目不存在 请刷新页面');
    	}
    	$material = Material::find($data['material_id']);
    	if(!$material)
    	{
    		$this->error_message('材料不存在 请刷新页面');
    	}
    	$data['name'] = $material->name;
    	$data['univalent'] = $material->purchase_price;
    	$data['code'] = $material->code;
    	if(Plan::create($data))
    	{
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }

    public function plan_edit(Request $request)
    {
    	$data = $request->post('data');
    	if(!Project::find($data['project_id']))
    	{
    		$this->error_message('项目不存在 请刷新页面');
    	}
    	$material = Material::find($data['material_id']);
    	if(!$material)
    	{
    		$this->error_message('材料不存在 请刷新页面');
    	}
    	$model = Plan::find($data['id']);
    	if(!$model) $this->error_message('数据不存在 请刷新页面');

    	$model->project_id = $data['project_id'];
    	$model->material_id = $data['material_id'];
    	$model->plan_time = $data['plan_time'];
    	$model->num = $data['num'];
    	$model->save();
    	$this->success_message('编辑成功');
    }

    public function plan_del(Request $request)
    {
    	Plan::where('id',$request->id)->delete();
    	$this->success_message('删除成功');
    }

    public function plan_order(Request $request)
    {
    	$model = Plan::find($request->id);
    	if(!$model) $this->error_message('数据不存在 请刷新页面');
    	$model->order_time = $request->order_time;
    	$model->remarks = $request->remarks;
    	$model->recommend = $request->recommend?2:1;
    	$model->status = $request->status?2:1;
    	$model->save();
    	$this->success_message('提交成功');
    }

    public function order(Request $request)
    {
    	if($request->isMethod('get'))
    	{
    		return view('Supplier.Plan.order');
    	}else
    	{	
    		$status = $request->get('status','');
    		$code = $request->get('code','');
			$data = Plan::select('*')
    				->with(['Project'=>function($query){
    					return $query->select('id','name')->get();
    				}])
    				->where('status','like','%'.$status.'%')
    				->where('code','like','%'.$code.'%')
    				->orderBy('created_at','DESC')
    				->offset(($request->offset - 1) * $request->limit)
    				->limit($request->limit)
    				->get();
    		foreach($data as $k => $v)
    		{
    			$data[$k]->project_name = $v->Project->name;
    			$data[$k]->total = bcmul($v->univalent,$v->num,2); 
    			$data[$k]['is_recommend'] = $v->recommend==2?'推荐':'不推荐';
    			$data[$k]['is_status'] = $v->status==2?'完成':'未完成';
    		}
    		$total = Plan::select('*')
    				->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }
}
