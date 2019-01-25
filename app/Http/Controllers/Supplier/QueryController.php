<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Design\Material;
use App\Model\Engineering\House;
class QueryController extends Controller
{
    public function query(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status','2')->get();
    		return view('Supplier.Query.query',[
    			'request'=>$request->all(),
    			'project'=>$project
    		]);
    	}else
    	{
            $formData = $request->post('data',false);
            if(!$formData)
            {
                $this->tableData(0,[],'获取成功',0);
            }
            $data = House::select('*')
                        ->where('project_id',$formData['project_id'])
                        ->where('unit',$formData['unit'])
                        ->where('building',$formData['building'])
                        ->where('floor',$formData['floor'])
                        ->where('room_number',$formData['room_number'])
                        ->first();

            if(!$data)
            {
                $this->tableData(0,[],'获取成功',0);
            }
            $data = $data->Material->toArray();
            foreach($data as $k => $v)
            {
                $data[$k]['total'] = ($v['settlement_price'] * $v['num']) + $v['other_price'];
            }
            $this->tableData(null,$data,'获取成功',0);
    	}
    }

    public function query_project(Request $request)
    {
        if($request->isMethod('get'))
        {   
            $project = Project::where('status','2')->get();
            return view('Supplier.Query.query_project',[
                'request'=>$request->all(),
                'project'=>$project
            ]);
        }else
        {
            $formData = $request->post('data',false);
            if(!$formData)
            {
                $this->tableData(0,[],'获取成功',0);
            }
            $project_id = $formData['project_id'];
            $project = Project::find($project_id);
            if(!$project)
            {
                $this->tableData(0,[],'获取成功',0);
            }

            $data = array();
            $houseList = $project->Houses;

            foreach($houseList as $v)
            {
                if($v->Material)
                {   
                    foreach($v->Material->toArray() as $val)
                    {
                        $tmp = array();
                        $tmp['category'] = $val['category'];
                        $tmp['class'] = $val['class'];
                        $tmp['code'] = $val['code'];
                        $tmp['brand'] = $val['brand'];
                        $tmp['model'] = $val['model'];
                        $tmp['spec'] = $val['spec'];
                        $tmp['color'] = $val['color'];
                        $tmp['metering'] = $val['metering'];
                        $tmp['parts_num'] = $val['parts_num'];
                        $tmp['place'] = $val['place'];
                        if(count($data) <= 0)
                        {
                            $tmp['num'] = $val['num'];
                            array_push($data,$tmp);
                        }else
                        {   
                            $init = true;
                            foreach($data as $key => $value)
                            {   
                                
                                unset($value['num']);
                                if(array_diff($value,$tmp) == null)
                                {   
                                    $data[$key]['num'] += $val['num'];
                                    $init = false;
                                    break;
                                }
                            }
                            if($init)
                            {
                                $tmp['num'] = $val['num'];
                                array_push($data,$tmp);
                            }
                            
                        }
                    }
                }
            }
            $this->tableData(null,$data,'获取成功',0);
        }
    }
}
