<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Developer\Project;
use App\Model\Design\Huxing;
use App\Model\Design\User;
use App\Model\Design\Demand;
use App\Model\Design\Schedule;
use App\Model\Design\Drawing;
use App\Model\Engineering\House;
use App\Model\Design\Material;
use App\Model\Engineering\Album;
use App\Model\Engineering\Schedule as EngineeringSchedule;
use App\Model\Engineering\Material as EngineeringMaterial;
use App\Model\Cost\CostEstimateDetailed;
use App\Model\Finance\HousePrice;

class HouseController extends Controller
{
	public function huxing(Request $request)
	{
	   if($request->isMethod('get'))
	    {	
	    	$project = Project::where('status',2)->get();
	        return view('Design.House.huxing',[
	            'project' => $project,
	        ]);
	    }else if($request->isMethod('post'))
	    {
	        $project_id = $request->post('project_id',false)?$request->project_id:'';
	        $data = Huxing::select('*')
	                ->where('project_id','like','%'.$project_id.'%')
	                ->where('status','>',0)
	                ->with(['Project'=>function($query){
	                	return $query->select('id','name')->get();
	                }])
	                ->orderBy('project_id','DESC')
	                ->offset(($request->page -1) * $request->limit)
	                ->limit($request->limit)
	                ->get()
	                ->toArray();
	        $total = Huxing::where('status','>',0)
	                        ->where('project_id','like','%'.$project_id.'%')
	                        ->count();
	        $this->tableData($total,$data,'获取成功',0);
	    }
	}

	public function huxing_add(Request $request)
	{
		$name = strtoupper($request->name);
		$project_id = $request->project_id;
		if(!Project::find($project_id))
		{
			$this->error_message('项目不存在');
		}
		if(Huxing::where('name',$name)->where('project_id',$project_id)->first())
		{
			$this->error_message('户型已存在');
		}

		if(Huxing::create(['name'=>$name,'project_id'=>$project_id]))
		{
			$this->success_message('添加成功');
		}else
		{
			$this->success_message('添加失败');
		}
	}
	public function huxing_edit(Request $request)
	{
		$name = strtoupper($request->name);
		$huxing = Huxing::find($request->id);
		$oldName = Huxing::where('name',$name)->where('project_id',$request->project_id)->first();
		if($oldName && $oldName->id != $huxing->id)
		{
			$this->error_message('户型已存在');
		}
		$huxing->name = $name;
		$huxing->project_id = $request->project_id;
		$huxing->save();
		$this->success_message('修改成功');
	}

	public function huxing_del(Request $request)
	{  
		$id = $request->id;
		if(!is_array($id))
		{
			$id = array($id);
		}
		foreach($id as $v)
		{	
			$model = Huxing::find($v);
			if($model->dwg_image)
			{
				@unlink('.'.$model->dwg_image);
			}
			if($model->effect_image)
			{
				@unlink('.'.$model->effect_image);
			}
		}
		Huxing::destroy($id);
		$this->success_message('删除成功');
	}
	public function huxing_upload(Request $request)
	{
		$id = $request->id;
		$huxing = Huxing::find($id);
		if(!$huxing)
		{
			$this->error_message('上传失败 数据不存在');
		}

	    if($request->hasFile('dwg_upload'))
	    {
	        if($request->file('dwg_upload')->isValid())
	        {
	            $extension = $request->dwg_upload->extension();
	            if($extension != 'dwg')
	            {
	            	$this->error_message('请上传DWG文件');
	            }
	            $newName = $huxing->name.'户型'.mt_rand(1111,9999).'.'.$extension;
	            $url = $request->dwg_upload->storeAs('/design/huxing/dwg',$newName,'upload');
	            if($url)
	            {   
	                $image = $huxing->dwg_image;
	                $path = env('UPLOAD').'/'.$url;
	                $huxing->dwg_image = $path;
	                $res = $huxing->save();
	                if($res)
	                {  
	                    if($image)
	                    {
	                        @unlink(substr($image,1));
	                    }
	                    $this->success_message('上传成功',['src'=>asset($path)]);
	                }else
	                {
	                    @unlink(substr($path,1));
	                    $this->error_message('上传失败');
	                }
	            }
	        }
	    }
	    if($request->hasFile('effect_image'))
	    {
	        if($request->file('effect_image')->isValid())
	        {
	            $extension = $request->effect_image->extension();
	            if($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png')
	            {
	            	$this->error_message('请上传图片');
	            }
	            $newName = $huxing->name.'户型'.mt_rand(1111,9999).'.'.$extension;
	            $url = $request->effect_image->storeAs('/design/huxing/image',$newName,'upload');
	            if($url)
	            {   
	                $image = $huxing->effect_image;
	                $path = env('UPLOAD').'/'.$url;
	                $huxing->effect_image = $path;
	                $res = $huxing->save();
	                if($res)
	                {  
	                    if($image)
	                    {
	                        @unlink(substr($image,1));
	                    }
	                    $this->success_message('上传成功',['src'=>asset($path)]);
	                }else
	                {
	                    @unlink(substr($path,1));
	                    $this->error_message('上传失败');
	                }
	            }
	        }
	    }
	}
	public function huxing_download(Request $request)
	{
		$model = Huxing::find($request->a);
		if(!$model)
		{
			die('下载失败');
		}

		if($request->c = 'dwg_image')
		{
			return response()->download('.'.$model->dwg_image);
		}

		die('下载失败');
	}

	public function house(Request $request)
	{
		if($request->isMethod('get'))
		{	
	        $project = Project::where('status',2)->get();
			return view('Design.House.house',[
				'request' => $request->all(),
	            'project' => $project,
	            'style' => array('简欧','简美','港式','美式','欧式','混搭','田园','现代','新古典','东南亚','日式','宜家','北欧','简约','韩式','地中海','中式','法式','工业风','新中式','清水房','其他')
			]);
		}else
		{
			$room_number = $request->post('name',false)?$request->name:'';
			$project_id = $request->post('project_id',false)?$request->project_id:'';
			$data = House::select('*')
	                ->where('room_number','like','%'.$room_number.'%')
					->where('project_id','like','%'.$project_id.'%')
	                ->where('status','>',0)
	                ->with(['Huxing'=>function($query){
	                    return $query->select('*')->get();
	                }])
	                ->with(['Project'=>function($query){
	                    return $query->select('id','name')->get();
	                }])
	                ->with(['User'=>function($query){
	                    return $query->select('id','username','phone')->get();
	                }])
					->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
		   	foreach($data as $k=>$v)
		   	{
		   		if($v['huxing'])
		   		{
	                $data[$k]['huxing_name'] = $v['huxing']['name'];
		   		}
	            if($v['project'])
	            {
	                $data[$k]['project_name'] = $v['project']['name'];
	            }
	            if($v['user'])
	            {
	                $data[$k]['user_name'] = $v['user']['username'];
	                $data[$k]['user_phone'] = $v['user']['phone'];
	            }
		   	}
			$total = House::where('room_number','like','%'.$room_number.'%')
					->where('project_id','like','%'.$project_id.'%')
	                ->where('status','>',0)
	                ->count();
			$this->tableData($total,$data,'获取成功',0);
		}
	}
	public function house_add(Request $request)
	{
		$data = $request->except('_token');
		if(House::where('room_number',$data['room_number'])->where('floor',$data['floor'])->where('building',$data['building'])->where('unit',$data['unit'])->where('project_id',$data['project_id'])->first())
		{
			$this->error_message('房号已被添加');
		}

		if(House::create($data))
		{
			$this->success_message('新增成功');
		}else
		{
			$this->error_message('新增失败');
		}
	}

	public function house_edit(Request $request)
	{	
		if($request->isMethod('get'))
		{
			$model = House::find($request->house_id);
			if(!$model) dd('数据不存在');
			return view('Design.House.edit',[
				'model'=>$model
			]);
		}else
		{
	        $data = $request->except('_token');
	        $model = House::find($data['id']);
	        if(!$model)
	        {
	            $this->error_message('数据不存在');
	        }
	        $oldHouse = House::where('room_number',$data['room_number'])->where('floor',$data['floor'])->where('building',$data['building'])->where('unit',$data['unit'])->where('project_id',$model->project_id)->first();
	        if($oldHouse && $oldHouse->id != $model->id)
	        {
	            $this->error_message('当前房号已存在');
	        }
	        House::where('id',$data['id'])->update($data);
	        $this->success_message('修改成功');
		}

	}
	public function house_del(Request $request)
	{
	    $id = $request->id;
	    $model = House::find($id);
	    if($model)
	    {   
	    	if(EngineeringMaterial::where('house_id',$model->id)->first() || EngineeringSchedule::where('house_id',$model->id)->first() || Album::where('house_id',$model->id)->first() || CostEstimateDetailed::where('house_id',$model->id)->first() || HousePrice::where('house_id',$model->id)->first() )
	    	{
	    		$this->error_message('已禁止删除');
	    	}
	    	if($model->user_id)
	    	{
	    		User::where('id',$model->user_id)->delete();
	    		Schedule::where('user_id',$model->user_id)->delete();
	    	}
	    	Demand::where('house_id',$model->id)->delete();
	    	Drawing::where('house_id',$model->id)->delete();
	    	Material::where('house_id',$model->id)->delete();

	    	EngineeringMaterial::where('house_id',$model->id)->delete();
	    	EngineeringSchedule::where('house_id',$model->id)->delete();
	    	Album::where('house_id',$model->id)->delete();
	    	CostEstimateDetailed::where('house_id',$model->id)->delete();
	        EngineeringMaterial::where('house_id',$model->id)->delete();
	        House::where('id',$id)->delete();

	    }
	    $this->success_message('删除成功');
	}
}
