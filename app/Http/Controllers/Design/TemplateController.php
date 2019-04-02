<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;
class TemplateController extends Controller
{
    public function template(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status',2)->get();
    		return view('Design.Template.template',[
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
    		$data = House::select('building','unit','floor','room_number','acreage','user_id','project_id','huxing_id','id','is_template')
                    ->with(['Project'=>function($query){
                    	return $query->select('name','id');
                    }])
                    ->with(['Demand'=>function($query){
                    	return $query->select('arrangement','style','like','demand','house_id');
                    }])
                    ->with(['Huxing'=>function($query){
                    	return $query->select('name','id');
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

    public function template_band(Request $request)
    {
    	$id = $request->post('id');
    	$is_template = $request->post('is_template') === 'true' ?1 :0;
    	$house = House::find($id);
    	if(!$house)
    	{
    		$this->error_message('数据不存在');
    	}
    	if($house->template_id)
    	{
    		$this->error_message('操作失败 : 房屋已绑定样板套装');
    	}
        if($is_template !== 1)
        {
            House::where('template_id',$house->id)->update(['template_id'=>null]);
        }
    	$house->is_template = $is_template;
    	$house->save();
    	$this->success_message('操作成功');
    }
}
