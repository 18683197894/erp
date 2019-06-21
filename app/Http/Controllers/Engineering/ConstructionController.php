<?php

namespace App\Http\Controllers\Engineering;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Engineering\House;
use App\Model\Developer\Project;
use App\Model\Supplier\Material;
use App\Model\Engineering\Material as EngineeringMaterial;
class ConstructionController extends Controller
{
    public function construction(Request $request)
    {	
    	$project = Project::where('status','2')->get();
    	if($request->isMethod('get'))
    	{	
    		return view('Engineering.Construction.construction',[
    			'project' => $project
    		]);
    	}else
    	{
			$data = House::select('*')
            ->with(['Project'=>function($query){
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
		    foreach($data as $k => $v) 
		    {   
                $data[$k]['project_name'] = $v['project']['name'];
                $data[$k]['a_num'] = 0;
                $data[$k]['a_total'] = 0.00;
                $data[$k]['b_num'] = 0;
                $data[$k]['b_total'] = 0.00;
                $data[$k]['c_total'] = 0.00;
                $data[$k]['d_total'] = 0.00;
                $data[$k]['e_total'] = 0.00;
                foreach($v['engineering_materials'] as $key =>$val)
                {
                    if($val['class_a'] == '主材')
                    {
                        $data[$k]['a_num'] += $val['num'];
                        $data[$k]['a_total'] =  bcadd($data[$k]['a_total'],bcmul($val['purchase_price'],$val['num'],2),2);
                    }else if($val['class_a'] == '辅材')
                    {
                        $data[$k]['b_num'] += $val['num'];
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

    public function plan(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$house = House::find($request->get('house_id'));
    		if(!$house) dd('数据不存在');
    		$material = Material::select('id','code')->where('status','>',0)->where('sale_price','>',0)->where('purchase_price','>',0)->get();
    		return view('Engineering.Construction.plan',[
    			'material' => $material,
    			'house' => $house
    		]);
    	}else
    	{
    		$data = EngineeringMaterial::select('*')
                    ->where('house_id',$request->house_id)
                    ->orderBy('time','DESC')
                    ->offset(($request->page - 1) * $request->limit)
                    ->limit($request->limit)
                    ->get();
            foreach($data as $k => $v)
            {
                $data[$k]->total = bcmul($v->purchase_price , $v->num,2);
                $data[$k]->count = bcadd(bcadd($data[$k]->total , $v->artificial_price,2),$v->other_price,2);
            }
            $total = EngineeringMaterial::select('*')
                    ->where('house_id',$request->house_id)
                    ->count();
            $this->tableData($total,$data,'获取成功',0);

    	}
    }

    public function plan_add(Request $request)
    {
        $data = $request->except('_token');
        $material = Material::where('status','>','0')->where('sale_price','>',0)->where('purchase_price','>',0)->where('id',$data['material_id'])->first();
        if(!$material)
        {
            $this->error_message('材料不存在 请刷新页面');
        }
        $house = House::where('status','>','0')->where('id',$data['house_id'])->first();
        if(!$house)
        {
            $this->error_message('房屋不存在 请刷新页面');
        }
        $data['class_a'] = $material->class_a;
        $data['class_b'] = $material->class_b;
        $data['code'] = $material->code;
        $data['brand'] = $material->brand;
        $data['model'] = $material->model;
        $data['spec'] = $material->spec;
        $data['color'] = $material->color;
        $data['parts_num'] = $material->parts_num;
        $data['place'] = $material->place;
        $data['metering'] = $material->metering;
        $data['supply_name'] = $material->supply->name;
        $data['supply_code'] = $material->supply->code;
        $data['supply_id'] = $material->supply->id;
        $data['material_name'] = $material->name;
         $data['purchase_price'] = $material->purchase_price; 
        if(EngineeringMaterial::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('新增失败');
        }
    }

    public function plan_edit(Request $request)
    {
        $data = $request->except('_token','code');
        EngineeringMaterial::where('id',$data['id'])->update($data);
        $this->success_message('修改成功');
    }

    public function plan_del(Request $request)
    {
        EngineeringMaterial::destroy($request->id);
        $this->success_message('删除成功');
    }
}
