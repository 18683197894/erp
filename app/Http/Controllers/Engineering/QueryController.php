<?php

namespace App\Http\Controllers\Engineering;

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
    		$project = Project::where('status','2')->get();
    		return view('Engineering.Query.query',[
    			'project' => $project
    		]);
    	}else
    	{
    		$data = House::select('*')
                    ->with(['Schedules'=>function($query){
                        return $query->select('id','house_id','details','serial_number')->orderBy('serial_number','DESC')->get();
                    },'Huxing'=>function($query){
                        return $query->select('id','name')->get();
                    },'Project'=>function($query){
                        return $query->select('id','name')->get();
                    },'EngineeringMaterials'=>function($query){
                        return $query->select()->get();
            		}])
                    ->where([
                        ['status','>',0],
                        ['project_id','like','%'.$request->get('project_id','').'%'],
                        ['building','like','%'.$request->get('building','').'%'],
                        ['unit','like','%'.$request->get('unit','').'%'],
                        ['floor','like','%'.$request->get('floor','').'%']
                    ])
					->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();

		    foreach ($data as $k => $v) 
		    {   
                $data[$k]['project_name'] = $v['project']['name'];
                if(isset($value['schedules'][0]))
                {   
                    
                    $data[$k]['schedule_name'] = $v['schedules'][0]['details'];
                }else
                {
                    $data[$k]['schedule_name'] = '未开工';
                }
		    	if($v['huxing'])
		    	{
		    		$data[$k]['huxing_name'] = $v['huxing']['name'];
		    	}
		    	$data[$k]['project_name'] = $v['project']['name'];
                $data[$k]['a_total'] = 0.00;
                $data[$k]['b_total'] = 0.00;
                $data[$k]['c_total'] = 0.00;
                $data[$k]['d_total'] = 0.00;
                $data[$k]['e_total'] = 0.00;
                foreach($v['engineering_materials'] as $key =>$val)
                {
                    if($val['class_a'] == '主材')
                    {
                        $data[$k]['a_total'] =  bcadd($data[$k]['a_total'],bcmul($val['purchase_price'],$val['num'],2),2);
                    }else if($val['class_a'] == '辅材')
                    {
                        $data[$k]['b_total'] =  bcadd($data[$k]['b_total'],bcmul($val['purchase_price'],$val['num'],2),2);
                    }else if($val['class_a'] == '家具' || $val['class_a'] == '家电')
                    {
                        $data[$k]['c_total'] =  bcadd($data[$k]['c_total'],bcmul($val['purchase_price'],$val['num'],2),2);
                    }
                    $data[$k]['d_total'] = bcadd($data[$k]['d_total'],bcadd($val['artificial_price'],$val['other_price'],2),2);
                    $data[$k]['e_total'] = bcadd(bcadd(bcadd($data[$k]['a_total'],$data[$k]['b_total'],2),$data[$k]['c_total'],2),$data[$k]['d_total'],2);
                }
		    }
			$total = House::select('*')
                    ->where([
                        ['status','>',0],
                        ['project_id','like','%'.$request->get('project_id','').'%'],
                        ['building','like','%'.$request->get('building','').'%'],
                        ['unit','like','%'.$request->get('unit','').'%'],
                        ['floor','like','%'.$request->get('floor','').'%']
                    ])
	                ->count();
			$this->tableData($total,$data,'获取成功',0);
		}
    	
    }
}
