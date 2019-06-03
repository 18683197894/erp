<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Finance\HousePrice;
class QueryController extends Controller
{
    public function comprehensive(Request $request)
    {
    	if($request->isMethod('get'))
    	{
    		return view('Finance.Query.comprehensive');
    	}else
    	{
    		$data = Project::select('*')
    			->where('status',2)
    			->with('HousePrices')
    			->offset(($request->page - 1) * $request->limit)
    			->limit($request->limit)
    			->get();

    		foreach($data as $k => $v)
    		{
    			$data[$k]->total_should = 0;
                $data[$k]->total_money = 0;
                $data[$k]->total_zhichu = 0;
                $data[$k]->material_price = 0;
                $data[$k]->artificial_price = 0;
                $data[$k]->other_price = 0;
                $data[$k]->price_surplus = 0;
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
                    if($vv->price_cost == 0)
                    {
                    	switch ($vv->price_purpose) {
                    		case '材料费用':
                    			$data[$k]->material_price = bcadd($data[$k]->material_price,$vv->price_money,2);
                    			break;
                    		case '人工费用':
                    			$data[$k]->artificial_price = bcadd($data[$k]->artificial_price,$vv->price_money,2);
                    			break;
                    		case '其他费用':
                    			$data[$k]->other_price = bcadd($data[$k]->other_price,$vv->price_money,2);
                    			break;
                    	}
                    }
                   
                }
                $data[$k]->income_difference = bcsub($data[$k]->total_money,$data[$k]->total_should,2);
                $data[$k]->total_should = $data[$k]->total_should?$data[$k]->total_should:'';
                $data[$k]->total_money = $data[$k]->total_money?$data[$k]->total_money:'';
                $data[$k]->total_zhichu = $data[$k]->total_zhichu?$data[$k]->total_zhichu:'';
                $data[$k]->material_price = $data[$k]->material_price?$data[$k]->material_price:'';
                $data[$k]->artificial_price = $data[$k]->artificial_price?$data[$k]->artificial_price:'';
                $data[$k]->other_price = $data[$k]->other_price?$data[$k]->other_price:'';
                if(!$data[$k]->total_should && !$data[$k]->total_money) $data[$k]->income_difference = '';

                $data[$k]->price_surplus = bcsub($v->price_budget,$data[$k]->total_zhichu,2);
                if(!$v->price_budget)
                {
                	$data[$k]->price_surplus = '';
                }

    		}
    		$total = Project::select('*')
    			->where('status',2)
    			->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function budget(Request $request)
    {
    	if($request->isMethod('get'))
    	{
    		return view('Finance.Query.budget');
    	}else
    	{
			$data = Project::select('*')
    			->where('status',2)
    			->with(['HousePrices'=>function($query){
    				return $query->select('*')->where('price_cost',0);;
    			}])
    			->offset(($request->page - 1) * $request->limit)
    			->limit($request->limit)
    			->get();

    		foreach($data as $k => $v)
    		{	
    			$data[$k]->price_surplus = 0;
                $data[$k]->price_already = 0;
                foreach($v->HousePrices as $kk => $vv)
                {   
                    
                    $data[$k]->price_already = bcadd($data[$k]->price_already,$vv->price_money,2);
                   
                }
                $data[$k]->price_already = $data[$k]->price_already?$data[$k]->price_already:'';
                $data[$k]->price_surplus = bcsub($v->price_budget,$data[$k]->price_already,2);
                if(!$v->price_budget)
                {
                	$data[$k]->price_surplus = '';
                }
    		}
    		$total = Project::select('*')
    			->where('status',2)
    			->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function budget_edit(Request $request)
    {
    	$model = Project::find($request->id);
    	if($model)
    	{
    		$model->price_budget = $request->price_budget;
    		$model->construction_stage = $request->construction_stage;
    		$model->finance_remarks = $request->finance_remarks;
    		if($model->save())
    		{
    			$this->success_message('编辑成功');
    		}else
    		{
    			$this->error_message('编辑失败');
    		}
    	}else
    	{
    		$this->error_message('数据不存在');
    	}
    }

    public function payment(Request $request)
    {
    	if($request->isMethod('get'))
    	{
    		$project = Project::where('status','2')->get();
    		return view('Finance.Query.payment',[
    			'project'=>$project
    			]);
    	}else
    	{
    		$data = HousePrice::select('*')
    			->where('price_cost',0)
    			->where('project_id','like','%'.$request->get('project_id','').'%')
    			->whereHas('House',function($query) use($request){
    				return $query->select('*')
    						->where('building','like','%'.$request->get('building','').'%')
    						->where('unit','like','%'.$request->get('unit','').'%')
    						->where('floor','like','%'.$request->get('floor','').'%')
    						->where('room_number','like','%'.$request->get('room_number','').'%');
    			})
    			->with('House','Project')
    			->orderBy('payment_time','DESC')
    			->get();
    		foreach($data as $k => $v)
    		{
    			$data[$k]->project_name = $v->Project->name;
    			$data[$k]->building = $v->House->building;
    			$data[$k]->unit = $v->House->unit;
    			$data[$k]->floor = $v->House->floor;
    			$data[$k]->room_number = $v->House->room_number;
    		}
    		$total = HousePrice::select('*')
    			->where('price_cost',0)
    			->where('project_id','like','%'.$request->get('project_id','').'%')
    			->whereHas('House',function($query) use($request){
    				return $query->select('*')
    						->where('building','like','%'.$request->get('building','').'%')
    						->where('unit','like','%'.$request->get('unit','').'%')
    						->where('floor','like','%'.$request->get('floor','').'%')
    						->where('room_number','like','%'.$request->get('room_number','').'%');
    			})
    			->with('House','Project')
    			->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function income(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status','2')->get();
    		return view('Finance.Query.income',[
    			'project'=>$project
    			]);
    	}else
    	{
    		$data = HousePrice::select('*')
    			->where('price_cost',1)
    			->where('project_id','like','%'.$request->get('project_id','').'%')
    			->whereHas('House',function($query) use($request){
    				return $query->select('*')
    						->where('building','like','%'.$request->get('building','').'%')
    						->where('unit','like','%'.$request->get('unit','').'%')
    						->where('floor','like','%'.$request->get('floor','').'%')
    						->where('room_number','like','%'.$request->get('room_number','').'%');
    			})
    			->with('House','Project')
    			->orderBy('payment_time','DESC')
    			->get();
    		foreach($data as $k => $v)
    		{
    			$data[$k]->project_name = $v->Project->name;
    			$data[$k]->building = $v->House->building;
    			$data[$k]->unit = $v->House->unit;
    			$data[$k]->floor = $v->House->floor;
    			$data[$k]->room_number = $v->House->room_number;
    		}
    		$total = HousePrice::select('*')
    			->where('price_cost',1)
    			->where('project_id','like','%'.$request->get('project_id','').'%')
    			->whereHas('House',function($query) use($request){
    				return $query->select('*')
    						->where('building','like','%'.$request->get('building','').'%')
    						->where('unit','like','%'.$request->get('unit','').'%')
    						->where('floor','like','%'.$request->get('floor','').'%')
    						->where('room_number','like','%'.$request->get('room_number','').'%');
    			})
    			->with('House','Project')
    			->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }
}
