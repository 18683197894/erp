<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;

class StatisticsController extends Controller
{
    public function comprehensive(Request $request)
    {
    	if($request->isMethod('get'))
    	{
    		return view('Cost.Statistics.comprehensive');
    	}else
    	{
    		$data = Project::select('*')
    				->where('status',2)
    				->with(['Houses'=>function($query){
    					return $query->select('*')
    							->with(['CostEstimateDetaileds'=>function($query){
    								return $query->select('*')->get();
    							}])
    							->get();
    				}])
    				->offset(($request->page -1 ) * $request->limit)
    				->limit($request->limit)
    				->get();
    		foreach($data as $k => $v)
    		{	
    			$data[$k]->material_price = 0;
    			$data[$k]->artificial_price = 0;
    			$data[$k]['total_re'] = bcadd(bcadd(bcadd($v->material_price_re,$v->artificial_price_re,2),$v->manage_price_re,2),$v->other_price_re,2);
    			foreach($v->Houses as $kk => $vv)
    			{
    				foreach($vv->CostEstimateDetaileds as $kkk => $vvv)
    				{
    					$data[$k]->material_price = bcadd(bcadd(bcadd($data[$k]->material_price,$vvv->b_mechanics_price,2),$vvv->b_keel_price,2),$vvv->b_main_price,2);
    					$data[$k]->artificial_price = bcadd($data[$k]->artificial_price,$vvv->b_contract_price,2);
    				}
    			}
    			$data[$k]->total = bcadd(bcadd(bcadd($data[$k]->material_price,$data[$k]->artificial_price,2),$v->manage_price,2),$v->other_price,2);
    			$data[$k]->difference = bcsub($data[$k]->total,$data[$k]->total_re,2);
    			$data[$k]->artificial_price = $data[$k]->artificial_price?$data[$k]->artificial_price:'';
    			$data[$k]->material_price = $data[$k]->material_price?$data[$k]->material_price:'';

    		}
    		$total = Project::select('*')
    				->where('status',2)
    				->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function comprehensive_edit(Request $request)
    {
    	$data = $request->except('_token','name','material_price','artificial_price');
    	$project = Project::find($data['id']);
    	if(!$project) $this->error_message('编辑失败 数据不存在');
    	$project->manage_price = $data['manage_price'];
    	$project->other_price = $data['other_price'];
    	$project->material_price_re = $data['material_price_re'];
    	$project->artificial_price_re = $data['artificial_price_re'];
    	$project->manage_price_re = $data['manage_price_re'];
    	$project->other_price_re = $data['other_price_re'];

    	if($project->save())
    	{
    		$this->success_message('编辑成功');
    	}else
    	{
    		$this->error_message('编辑失败');
    	}
    }
}
