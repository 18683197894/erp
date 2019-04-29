<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Engineering\House;
use App\Model\Developer\Project;
use App\Model\Design\Material;
use App\Model\Supplier\Material as SupplierMaterial;
class MaterialController extends Controller
{
    public function material(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status',2)->get();
    		return view('Design.Material.material',[
    			'project'=>$project
    		]);
    	}else
    	{	
    		$formData['project_id'] = $request->post('project_id','');
    		$formData['unit'] = $request->post('unit','');
    		$formData['building'] = $request->post('building','');
    		$formData['floor'] = $request->post('floor','');
    		$formData['room_number'] = $request->post('room_number','');
    		$data = House::select('id','building','unit','floor','room_number','acreage','project_id')
    				->with(['Project'=>function($query){
                    	return $query->select('name','id');
                    }])
                    ->with(['Materials'=>function($query){
                    	return $query->select('id','settlement_price','num','other_price','house_id','class_a');
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
    			$data[$k]->zhucai_num = 0;
    			$data[$k]->zhucai_total = 0;
    			$data[$k]->fucai_num = 0;
    			$data[$k]->fucai_total = 0;
    			$data[$k]->jiaju_num = 0;
    			$data[$k]->jiaju_total = 0;
    			$data[$k]->jiadian_num = 0;
    			$data[$k]->jiadian_total = 0;
    			foreach($v->Materials as $val)
    			{
    				if($val->class_a === '主材' )
    				{
    					$data[$k]->zhucai_num += $val->num; 
    					$data[$k]->zhucai_total = bcadd($data[$k]->zhucai_total,bcadd(bcmul($val->settlement_price , $val->num,2),$val->other_price,2),2) ; 
    				}
    				if($val->class_a === '辅材' )
    				{   
                        $data[$k]->fucai_num += $val->num; 
    					$data[$k]->fucai_total = bcadd($data[$k]->fucai_total,bcadd(bcmul($val->settlement_price , $val->num,2),$val->other_price,2),2) ;  
    				}
    				if($val->class_a === '家具' )
    				{
    					$data[$k]->jiaju_num += $val->num; 
    					$data[$k]->jiaju_total = bcadd($data[$k]->jiaju_total,bcadd(bcmul($val->settlement_price , $val->num,2),$val->other_price,2),2) ; 
    				}
    				if($val->class_a === '家电' )
    				{
    					$data[$k]->jiadian_num += $val->num; 
    					$data[$k]->jiadian_total = bcadd($data[$k]->jiadian_total,bcadd(bcmul($val->settlement_price , $val->num,2),$val->other_price,2),2) ;  
    				}
    			}
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

    public function list(Request $request)
    {	

    	if($request->isMethod('get'))
    	{	
    		$house = House::find($request->house_id);
    		if(!$house)
    		{
    			die('数据不存在');
    		}
    		return view('Design.Material.list',[
    			'house'=>$house
       		]);
       	}else
    	{
			$house_id = $request->house_id;
            $data = Material::select('*')
                    ->where('house_id',$house_id)
                    ->where('status','>',0)
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            foreach($data as $k => $v)
            {
            	$data[$k]['total'] = ($v['settlement_price'] * $v['num']) + $v['other_price'];
            }
            $total = Material::where('status','>',0)
                            ->where('house_id',$house_id)
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }
    public function list_edit(Request $request)
    {
    	$model = Material::find($request->id);
    	if(!$model)
    	{
    		$this->error_message('数据不存在');
    	}
    	$model->position = $request->position;
    	$model->num = $request->num;
    	$model->remarks = $request->remarks;
    	$model->other_price = $request->other_price;
    	if(empty($request->other_price))
    	{
    		$model->other_explain = null;
    	}else
    	{
    		$model->other_explain = $request->other_explain;
    	}
    	if($model->save())
    	{
    		$this->success_message('编辑成功');
    	}else
    	{
    		$this->error_message('编辑失败');
    	}

    }
    public function list_del(Request $request)
    {
    	Material::where('id',$request->id)->delete();
    	$this->success_message('删除成功');
    }
    public function list_selection(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$house = House::find($request->house_id);
    		return view('Design.Material.list_selection',[
    			'house'=>$house
    		]);
    	}else
    	{	
    		$class_a = $request->get('class_a','');
    		$code = $request->get('code','');
			$data = SupplierMaterial::select('*')
                    ->where([
                        ['status','>',0],
                        ['code','like','%'.$code.'%'],
                        ['class_a','like','%'.$class_a.'%']
                    ])
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get();
            foreach($data as $k => $v)
            {
            	if($v->promotion == 1)
            	{
            		if($v->start <= date('Y-m-d',time()))
            		{
            			if(!empty($v->end) && $v->end < date('Y-m-d',time()))
            			{
            				$data[$k]->promotion_price = '促销已结束';
            			}
            			if(empty($v->promotion_price))
            			{
            				$data[$k]->promotion_price = '无促销';
            			}
            		}else
            		{
            			$data[$k]->promotion_price = '促销未开始';
            		}
            	}else
            	{
            		$data[$k]->promotion_price = '无促销';
            	}
            }
            $total = SupplierMaterial::select('*')
                    ->where([
                        ['status','>',0],
                        ['code','like','%'.$code.'%'],
                        ['class_a','like','%'.$class_a.'%']
                    ])
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function list_selection_add(Request $request)
    {
    	$data = $request->except('_token','code');
    	$material = SupplierMaterial::where('status','>','0')->where('id',$data['material_id'])->first();
    	if(!$material)
    	{
    		$this->error_message('材料不存在 请刷新页面');
    	}
    	if(empty($data['other_price']))
    	{
    		$data['other_explain'] = null;
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
    	$data['supply'] = $material->supply->name;
    	$data['supply_code'] = $material->supply->code;
		if($material->promotion == 1)
		{	
			$a = $material->start <= date('Y-m-d',time()); //true
			$b = !empty($material->end) && $material->end < date('Y-m-d',time()); //false
			$c = !empty($material->promotion_price); //true
			if($a == true && $b == false && $c == true)
			{
				$data['promotion_price'] = $material->promotion_price;
				$data['settlement_price'] = $material->promotion_price;
			}else
			{
				$data['promotion_price'] = null;
				$data['settlement_price'] = $material->settlement_price;
			}
		}else
		{
			$data['promotion_price'] = null;
			$data['settlement_price'] = $material->settlement_price;
		}
    	$data['standard_price'] = $material->sale_price; //销售价
    	// $data['promotion_price'] = $material->promotion_price; //促销价
    	// $data['settlement_price'] = $material->settlement_price; //结算价
    	if(Material::create($data))
    	{
    		$this->success_message('选取成功');
    	}else
    	{
    		$this->error_message('选取失败');
    	}
    }
}
