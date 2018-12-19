<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Supplier\Supply;
use App\Model\Supplier\Category;
use App\Model\Supplier\Material;
class SupplierController extends Controller
{
    public function supply(Request $request)
    {
    	if($request->isMethod('get'))
    	{  
    		return view('Supplier.Supply.supply',[
                'request' => $request->all()
            ]);
    	}else if($request->isMethod('post'))
    	{	
			$name = $request->post('name',false)?$request->name:'';
    		$data = supply::where('name','like','%'.$name.'%')
                    ->where('status','>',0)
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
    		$total = supply::where('name','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}

    }
	public function supply_add(Request $request)
	{	
		$data = $request->except('_token');
		if(Supply::where('code',$data['code'])->first())
		{
			$this->error_message('供应商编码已存在');
		}

		if($data['start'] && $data['end'])
		{	
			if($data['start'] > $data['end'])
			{
				$this->error_message('从新选择合同时间');
			}
		}else
		{
			$data['start'] = null;
			$data['end'] = null;
		}
		if(Supply::create($data))
		{
			$this->success_message('新增成功');
		}else
		{
			$this->error_message('新增失败');
		}
	}

	public function supply_edit(Request $request)
	{
		$data = $request->except('_token');
		$model = Supply::where('code',$data['code'])->first();
		if($model && $model->id != $data['id'])
		{
			$this->error_message('供应商编码已存在');
		}
		if($data['start'] && $data['end'])
		{	
			if($data['start'] > $data['end'])
			{
				$this->error_message('从新选择合同时间');
			}
		}else
		{
			$data['start'] = null;
			$data['end'] = null;
		}
		Supply::where('id',$model->id)->update($data);
		$this->success_message('编辑成功');
	}
	public function supply_del(Request $request)
	{
		$id = $request->id;
		if(Material::where('supply_id',$id)->where('status','>',0)->first())
		{
			$this->error_message('已禁止删除');
		}
		Supply::where('id',$id)->delete();
		$this->success_message('删除成功');
	}
	public function category(Request $request)
	{
    	if($request->isMethod('get'))
    	{  
    		return view('Supplier.Material.category',[
                'request' => $request->all()
            ]);
    	}else if($request->isMethod('post'))
    	{	
			$name = $request->post('name',false)?$request->name:'';
			$class = $request->post('class',false)?$request->class:'';
    		$data = Category::where('name','like','%'.$name.'%')
    				->where('class','like','%'.$class.'%')
                    ->where('status','>',0)
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
    		$total = Category::where('name','like','%'.$name.'%')
    				->where('class','like','%'.$class.'%')
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
	}

	public function category_add(Request $request)
	{
		$data = $request->except('_token');

		if(Category::where('name',$data['name'])->first())
		{
			$this->error_message('品类已存在');
		}

		if(Category::create($data))
		{
			$this->success_message('新增成功');
		}else
		{
			$this->error_message('新增失败');
		}
	}

	public function category_edit(Request $request)
	{
		$data = $request->except('_token');
		$category = Category::find($data['id']);

		$re_category = Category::where('name',$data['name'])->first();

		if(!$category) $this->error_message('数据不存在');
		if($re_category && $category->id != $re_category->id) $this->error_message('品类已存在');

		$category->name = $data['name'];
		$category->class = $data['class'];
		$category->save();
		$this->success_message('修改成功');
	}
	public function category_del(Request $request)
	{
		if(Material::where('category_id',$request->id)->where('status','>',0)->first())
		{
			$this->error_message('已禁止删除');
		}

		Category::where('id',$request->id)->delete();
		$this->success_message('删除成功');
	}
	public function material(Request $request)
	{
		if($request->isMethod('get'))
    	{  
    		$urls = parse_url(\url()->previous());
            $category = Category::find($request->category_id);
            if(!$category)
            {
                return back();
            }
            return view('Supplier.Material.material',[
                'category' => $category,
                'supply' => Supply::where('status','>',0)->get(),
                'title' => $category->name,
                'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
    	}else if($request->isMethod('post'))
    	{	

			$code = $request->post('code',false)?$request->code:'';
    		$data = Material::where('code','like','%'.$code.'%')
    				->where('category_id',$request->category_id)
                    ->where('status','>',0)
                    ->with('Supply')
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
    		$total = Material::where('code','like','%'.$code.'%')
    				->where('category_id',$request->category_id)
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
	}

	public function material_add(Request $request)
	{
		$datas = json_decode($request->data);
		$data['code'] = $datas->code;
		$data['brand'] = $datas->brand;
		$data['spec'] = $datas->spec;
		$data['model'] = $datas->model;
		$data['color'] = $datas->color;
		$data['metering'] = $datas->metering;
		$data['cost_price'] = $datas->cost_price;
		$data['market_price'] = $datas->market_price;
		$data['sale_price'] = $datas->sale_price;
		$data['purchase_price'] = $datas->purchase_price;
		$data['gross_profit'] = $datas->gross_profit;
		$data['billing_time'] = $datas->billing_time;
		$data['settlement_ratio'] = $datas->settlement_ratio;
		$data['level'] = $datas->level;
		$data['style'] = $datas->style;
		$data['place'] = $datas->place;
		$data['recommend'] = isset($datas->recommend)?1:0;
		$data['available'] = isset($datas->available)?1:0;
		$data['promotion'] = isset($datas->promotion)?1:0;
		$data['explain'] = $datas->explain;
		$data['parts_num'] = $datas->parts_num;
		$data['settlement_cycle'] = $datas->settlement_cycle;
		$data['settlement_price'] = $datas->settlement_price;
		$data['remarks'] = $datas->remarks;
		$data['supply_id'] = $datas->supply_id;
		$data['category_id'] = $datas->category_id;
		$data['start'] = $datas->start;
		$data['end'] = $datas->end;
		$data['promotion_price'] = $datas->promotion_price?$datas->promotion_price:null;
		$data['promotion_settlement_price'] = $datas->promotion_settlement_price?$datas->promotion_settlement_price:0;
		$data['promotion_settlement_proportion'] = $datas->promotion_settlement_proportion;
		$data['activity_proportion'] = $datas->activity_proportion;
		$data['promotion_activity_proportion'] = $datas->promotion_activity_proportion;
		if($data['start'] && $data['end'])
		{	
			if($data['start'] > $data['end'])
			{
				$this->error_message('从新选择促销时间');
			}
		}else
		{
			$data['start'] = null;
			$data['end'] = null;
		}
		if(Material::where('code',$data['code'])->first())
		{
			$this->error_message('编码已存在');
		}
		if($request->image && $request->image != "undefined")
		{
	        if($request->hasFile('image'))
	        {
	            if($request->file('image')->isValid())
	            {
	                $extension = $request->image->extension();
	                if($extension != 'jpg' && $extension != 'jpeg' && $extension !='png' )
	                {
	                	$this->error_message('请上传图片');
	                }
	                $newName = time().mt_rand(11111,99999).'.'.$extension;
	                $url = $request->image->storeAs('/supplier/material/image',$newName,'upload');
	                if($url)
	                {   
	                   
	                    $path = env('UPLOAD').'/'.$url;
	                    $data['image'] = $path;
	                }
	            }
	        }
		}


		if(Material::create($data))
		{
			$this->success_message('添加成功');
		}else
		{	
			$this->error_message('添加失败');
		}
	}

	public function material_edit(Request $request)
	{
		$datas = json_decode($request->data);

		$data['code'] = $datas->code;
		$data['brand'] = $datas->brand;
		$data['spec'] = $datas->spec;
		$data['model'] = $datas->model;
		$data['color'] = $datas->color;
		$data['metering'] = $datas->metering;
		$data['cost_price'] = $datas->cost_price;
		$data['market_price'] = $datas->market_price;
		$data['sale_price'] = $datas->sale_price;
		$data['purchase_price'] = $datas->purchase_price;
		$data['gross_profit'] = $datas->gross_profit;
		$data['billing_time'] = $datas->billing_time;
		$data['settlement_ratio'] = $datas->settlement_ratio;
		$data['level'] = $datas->level;
		$data['style'] = $datas->style;
		$data['place'] = $datas->place;
		$data['recommend'] = isset($datas->recommend)?1:0;
		$data['available'] = isset($datas->available)?1:0;
		$data['promotion'] = isset($datas->promotion)?1:0;
		$data['explain'] = $datas->explain;
		$data['parts_num'] = $datas->parts_num;
		$data['settlement_cycle'] = $datas->settlement_cycle;
		$data['settlement_price'] = $datas->settlement_price;
		$data['remarks'] = $datas->remarks;
		$data['supply_id'] = $datas->supply_id;
		$data['id'] = $datas->id;
		$data['start'] = $datas->start;
		$data['end'] = $datas->end;
		$data['promotion_price'] = $datas->promotion_price?$datas->promotion_price:null;
		$data['promotion_settlement_price'] = $datas->promotion_settlement_price?$datas->promotion_settlement_price:0;
		$data['promotion_settlement_proportion'] = $datas->promotion_settlement_proportion;
		$data['activity_proportion'] = $datas->activity_proportion;
		$data['promotion_activity_proportion'] = $datas->promotion_activity_proportion;
		$model = Material::find($data['id']);
		if(!$model)
		{
			$this->error_message('数据不存在');
		}

		if($request->image && $request->image != "undefined")
		{
	        if($request->hasFile('image'))
	        {
	            if($request->file('image')->isValid())
	            {
	                $extension = $request->image->extension();
	                if($extension != 'jpg' && $extension != 'jpeg' && $extension !='png' )
	                {
	                	$this->error_message('请上传图片');
	                }
	                $newName = time().mt_rand(11111,99999).'.'.$extension;
	                $url = $request->image->storeAs('/supplier/material/image',$newName,'upload');
	                if($url)
	                {   
	                   
	                    $path = env('UPLOAD').'/'.$url;
	                    if($model->image)
	                    {
	                    	@unlink('.'.$model->image);
	                    }
	                    $model->image = $path;
	                    $model->save();
	                }
	            }
	        }
		}
		Material::where('id',$data['id'])->update($data);
		$this->success_message('修改成功');
	}

	public function material_del(Request $request)
	{	
		$model = Material::find($request->id);
		if($model)
		{
			if($model->image)
			{
				@unlink('.'.$model->image);
			}

			Material::where('id',$model->id)->delete();
		}
		$this->success_message('删除成功');
	}
}
