<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Engineering\House;
use App\Model\Design\Material;
use App\Model\Supplier\Material as SupplierMaterial;
use App\Model\Supplier\Category;
class MaterialController extends Controller
{
    public function material(Request $request)
    {	

    	if($request->isMethod('get'))
    	{	
    		$urls = parse_url(\url()->previous());
    		$house = House::find($request->house_id);
    		if(!$house)
    		{
    			return back();
    		}
    		$title = $house->project->name.$house->unit.'单元'.$house->building.'栋'.$house->floor.'层'.$house->room_number.'号';
    		return view('Design.Material.material',[
    			'request'=>$request->all(),
    			'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all()),
    			'house'=>$house,
    			'title'=>$title
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
    public function material_edit(Request $request)
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
    public function material_del(Request $request)
    {
    	Material::where('id',$request->id)->delete();
    	$this->success_message('删除成功');
    }
    public function material_selection(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$categroy = Category::where('status','>',0)->get();
    		$house = House::find($request->house_id);
    		return view('Design.Material.selection',[
    			'house'=>$house,
    			'categroy'=>$categroy
    		]);
    	}else
    	{	
    		$category_id = $request->get('category_id','');
    		$code = $request->get('code','');
			$data = SupplierMaterial::select('*')
					->where('status','>',0)
					->where('category_id','like','%'.$category_id.'%')
					->where('code','like','%'.$code.'%')
					->with(['Category'=>function($query){
						return $query->select('id','name','class')->get();
					}])
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            foreach($data as $k => $v)
            {
            	$data[$k]['category_name'] = $v['category']['name'];
            	$data[$k]['class_name'] = $v['category']['class'];

            	if($v['promotion'] == 1)
            	{
            		if($v['start'] <= date('Y-m-d',time()))
            		{
            			if(!empty($v['end']) && $v['end'] < date('Y-m-d',time()))
            			{
            				$data[$k]['promotion_price'] = '促销已结束';
            			}
            			if(empty($v['promotion_price']))
            			{
            				$data[$k]['promotion_price'] = '无促销';
            			}
            		}else
            		{
            			$data[$k]['promotion_price'] = '促销未开始';
            		}
            	}else
            	{
            		$data[$k]['promotion_price'] = '无促销';
            	}
            }
            $total = SupplierMaterial::select('id')
					->where('status','>',0)
            		->where('category_id','like','%'.$category_id.'%')
					->where('code','like','%'.$code.'%')
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function material_selection_add(Request $request)
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
    	$data['category'] = $material->Category->name;
    	$data['class'] = $material->Category->class;
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
