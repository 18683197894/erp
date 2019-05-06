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
                    	return $query->select('id','settlement_price','num','artificial_price','house_id','class_a');
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
                $data[$k]->rg_total = 0;
                $data[$k]->total = 0;
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

                $data[$k]->total = bcadd(bcadd(bcadd(bcadd($data[$k]->zhucai_total,$data[$k]->fucai_total,2),$data[$k]->jiaju_total,2), $data[$k]->jiadian_total,2),$data[$k]->rg_total,2);

                $data[$k]->zhucai_num = $data[$k]->zhucai_num?$data[$k]->zhucai_num:'';
                $data[$k]->zhucai_total = $data[$k]->zhucai_total?$data[$k]->zhucai_total:'';
                $data[$k]->fucai_num = $data[$k]->fucai_num?$data[$k]->fucai_num:'';
                $data[$k]->fucai_total = $data[$k]->fucai_total?$data[$k]->fucai_total:'';
                $data[$k]->jiaju_num = $data[$k]->jiaju_num?$data[$k]->jiaju_num:'';
                $data[$k]->jiaju_total = $data[$k]->jiaju_total?$data[$k]->jiaju_total:'';
                $data[$k]->jiadian_num = $data[$k]->jiadian_num?$data[$k]->jiadian_num:'';
                $data[$k]->jiadian_total = $data[$k]->jiadian_total?$data[$k]->jiadian_total:'';
                $data[$k]->rg_total = $data[$k]->rg_total?$data[$k]->rg_total:'';
                $data[$k]->total = $data[$k]->total?$data[$k]->total:'';
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
            $material = SupplierMaterial::select('id','code')->where('status','>',0)->get();
    		if(!$house)
    		{
    			die('数据不存在');
    		}
    		return view('Design.Material.list',[
    			'house'=>$house,
                'material' => $material
       		]);
       	}else
    	{
			$house_id = $request->house_id;
            $data = Material::select('*')
                    ->where('house_id',$house_id)
                    ->where('status','>',0)
                    ->orderBy('region')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            foreach($data as $k => $v)
            {   
                switch($v['region'])
                {
                    case 1:
                        $data[$k]['region_name'] = '土建部分';
                    break;
                    case 2:
                        $data[$k]['region_name'] = '客餐厅厨房区域';
                    break;
                    case 3:
                        $data[$k]['region_name'] = '卫生间区域';
                    break;
                    case 4:
                        $data[$k]['region_name'] = '卧室区域';
                    break;
                    case 5:
                        $data[$k]['region_name'] = '强弱电工程部分';
                    break;
                    case 6:
                        $data[$k]['region_name'] = '其他项目';
                    break;
                    case 7:
                        $data[$k]['region_name'] = '卫浴洁具类';
                    break;
                }
            	$data[$k]['total'] = bcadd(bcmul($v['settlement_price'],$v['num'],2),$v['artificial_price'],2);
            }
            $total = Material::where('status','>',0)
                            ->where('house_id',$house_id)
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function list_add(Request $request)
    {
        $data = $request->except('_token');
        $material = SupplierMaterial::where('status','>','0')->where('id',$data['material_id'])->first();
        if(!$material)
        {
            $this->error_message('材料不存在 请刷新页面');
        }
        $data['name'] = $material->name;
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
        $data['standard_price'] = $material->sale_price; 
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
                $data['settlement_price'] = $material->sale_price;
            }
        }else
        {
            $data['promotion_price'] = null;
            $data['settlement_price'] = $material->sale_price;
        }
        if(Material::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('新增失败');
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
    	$model->artificial_price = $request->artificial_price;
    	$model->region = $request->region;
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
