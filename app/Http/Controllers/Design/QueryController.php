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
    		$data = House::select('building','unit','floor','room_number','acreage','user_id','project_id','huxing_id','id','manual_cost','manual_sale_cost','material_cost','construction_cost','total','remarks')
                    ->with(['Project'=>function($query){
                    	return $query->select('name','id');
                    }])
                    ->with(['Demand'=>function($query){
                    	return $query->select('arrangement','style','like','demand','house_id');
                    }])
                    ->with(['Huxing'=>function($query){
                    	return $query->select('name','id');
                    }])
                    ->with('Schedules','Materials')
                    ->where('project_id','like','%'.$formData['project_id'].'%')
                    ->where('unit','like','%'.$formData['unit'].'%')
                    ->where('building','like','%'.$formData['building'].'%')
                    ->where('floor','like','%'.$formData['floor'].'%')
                    ->where('room_number','like','%'.$formData['room_number'].'%')
                    ->orderBy('created_at','Desc')
    				->offset(($request->page - 1) * $request->limit)
    				->limit($request->limit)
    				->get();
            // dd($data);
    		foreach($data as $k => $v)
    		{	
    			$data[$k]->project_name = $v->Project->name;
    			$data[$k]->huxing_name = isset($v->Huxing->name)?$v->Huxing->name:'';
                $data[$k]->money  = 0;
                $data[$k]->cost =0;
                foreach($v->Schedules as $vals)
                {
                    $data[$k]->money += $vals->money;
                }
                $data[$k]->money = number_format($data[$k]->money,2,'.','');
                foreach($v->Materials as $val)
                {
                    if($val->class_a === '主材' )
                    {
                        $data[$k]->zhucai_num += $val->num; 
                        $data[$k]->zhucai_total = bcadd($data[$k]->zhucai_total,bcmul($val->settlement_price , $val->num,2),2) ; 
                    }
                    if($val->class_a === '辅材' )
                    {   
                        $data[$k]->fucai_num += $val->num; 
                        $data[$k]->fucai_total = bcadd($data[$k]->fucai_total,bcmul($val->settlement_price , $val->num,2),2);  
                    }
                    if($val->class_a === '家具' )
                    {
                        $data[$k]->jiaju_num += $val->num; 
                        $data[$k]->jiaju_total = bcadd($data[$k]->jiaju_total,bcmul($val->settlement_price , $val->num,2),2); 
                    }
                    if($val->class_a === '家电' )
                    {
                        $data[$k]->jiadian_num += $val->num; 
                        $data[$k]->jiadian_total = bcadd($data[$k]->jiadian_total,bcmul($val->settlement_price , $val->num,2),2);  
                    }

                    $data[$k]->rg_total = bcadd($data[$k]->rg_total,$val->artificial_price,2);
                }

                $data[$k]->cost = bcadd(bcadd(bcadd(bcadd($data[$k]->zhucai_total,$data[$k]->fucai_total,2),$data[$k]->jiaju_total,2), $data[$k]->jiadian_total,2),$data[$k]->rg_total,2);
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
