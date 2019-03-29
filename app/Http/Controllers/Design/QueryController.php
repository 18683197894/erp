<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;
class QueryController extends Controller
{
    public function query(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status',2)->get();
    		return view('Design.Query.query',[
    			'project' => $project,
                'style' => array('简欧','简美','港式','美式','欧式','混搭','田园','现代','新古典','东南亚','日式','宜家','北欧','简约','韩式','地中海','中式','法式','工业风','新中式','清水房','其他')
    		]);
    	}else
    	{	
    		$formData['project_id'] = $request->post('project_id','');
    		$formData['unit'] = $request->post('unit','');
    		$formData['building'] = $request->post('building','');
    		$formData['floor'] = $request->post('floor','');
    		$formData['room_number'] = $request->post('room_number','');
    		$data = House::select('building','unit','floor','room_number','acreage','user_id','project_id','huxing_id','id','manual_cost','manual_sale_cost','material_cost','construction_cost')
                    ->with(['Project'=>function($query){
                    	return $query->select('name','id');
                    }])
                    ->with(['Demand'=>function($query){
                    	return $query->select('arrangement','style','like','demand','house_id');
                    }])
                    ->with(['Huxing'=>function($query){
                    	return $query->select('name','id');
                    }])
                    ->with(['User'=>function($query){
                    	return $query->select('total','id')->with(['Schedules'=>function($query){
                    		return $query->select('money','user_id');
                    	}]);
                    }])
                    ->where('project_id','like','%'.$formData['project_id'].'%')
                    ->where('unit','like','%'.$formData['unit'].'%')
                    ->where('building','like','%'.$formData['building'].'%')
                    ->where('floor','like','%'.$formData['floor'].'%')
                    ->where('room_number','like','%'.$formData['room_number'].'%')
                    ->orderBy('created_at','Desc')
    				->offset(($request->page - 1) * $request->limit)
    				->limit($request->limit)
    				->get();
    		foreach($data as $k => $v)
    		{	
    			$data[$k]->project_name = $v->Project->name;
    			$data[$k]->huxing_name = isset($v->Huxing->name)?$v->Huxing->name:'';
    			$data[$k]->cost  = number_format(($v->manual_cost + $v->manual_sale_cost + $v->material_cost + $v->construction_cost),2,'.','');
    			if(!$v->User) continue;
    			$data[$k]->total = $v->User->total;
    			if(!$v->User->SChedules) continue;
    			$data[$k]->money = 0;
    			foreach($v->User->Schedules as $val)
    			{
    				$data[$k]->money += $val->money;
    			}
    			$data[$k]->money = number_format($data[$k]->money,2,'.','');
    		}
    		$total = House::select('building','unit','floor','room_number','acreage','user_id')
    				->where('project_id','like','%'.$formData['project_id'].'%')
                    ->where('unit','like','%'.$formData['unit'].'%')
                    ->where('building','like','%'.$formData['building'].'%')
                    ->where('floor','like','%'.$formData['floor'].'%')
                    ->where('room_number','like','%'.$formData['room_number'].'%')
    				->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }
}
