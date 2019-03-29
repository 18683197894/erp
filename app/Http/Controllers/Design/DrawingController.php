<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Engineering\House;
use App\Model\Design\Drawing;
use App\Model\Design\Huxing;
use App\Model\Developer\Project;
class DrawingController extends Controller
{
    public function drawing(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
            $house = House::where('status','>',0)->get();
            $project = Project::where('status',2)->get();
    		return view('Design.Drawing.drawing',['project'=>$project,'house'=>$house]);
       	}else
    	{   
            $formData = $request->post('data',null);
            $data = Drawing::select('design_drawing.id','design_drawing.name','design_drawing.dwg_image','design_drawing.effect_image','design_drawing.house_id','engineering_house.room_number','engineering_house.floor','engineering_house.building','engineering_house.unit','engineering_house.acreage','developer_project.name as project_name','engineering_house.huxing_id','engineering_house.huxing_id')
                    ->join('engineering_house',function($join){
                        return $join->on('design_drawing.house_id','=','engineering_house.id');
                    })
                    ->join('developer_project',function($join){
                        return $join->on('engineering_house.project_id','=','developer_project.id');
                    })
                    ->where('engineering_house.project_id','like','%'.$formData['project_id'].'%')
                    ->where('engineering_house.unit','like','%'.$formData['unit'].'%')
                    ->where('engineering_house.building','like','%'.$formData['building'].'%')
                    ->where('engineering_house.floor','like','%'.$formData['floor'].'%')
                    ->where('engineering_house.room_number','like','%'.$formData['room_number'].'%')
                    ->offset(($request->page - 1) * $request->limit)
                    ->limit($request->limit)
                    ->get();
            foreach($data as $k => $v)
            {
                $huxing = Huxing::find($v->huxing_id);
                if($huxing)
                {
                    $data[$k]->huxing_name = $huxing->name;
                }
            }
            $total = Drawing::select('design_drawing.id','design_drawing.name','design_drawing.dwg_image','design_drawing.effect_image','design_drawing.house_id','engineering_house.room_number','engineering_house.floor','engineering_house.building','engineering_house.unit','engineering_house.acreage','developer_project.name as project_name','engineering_house.huxing_id')
                    ->join('engineering_house',function($join){
                        return $join->on('design_drawing.house_id','=','engineering_house.id');
                    })
                    ->join('developer_project',function($join){
                        return $join->on('engineering_house.project_id','=','developer_project.id');
                    })
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function drawing_add(Request $request)
    {
    	$name = $request->name;
    	$house_id = $request->house_id;
    	if(Drawing::where('house_id',$house_id)->where('name',$name)->first())
    	{
    		$this->error_message('图纸已存在');
    	}
    	if(Drawing::create(array('name'=>$name,'house_id'=>$house_id)))
    	{
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }

    public function drawing_edit(Request $request)
    {	
    	$name = $request->name;
    	$id = $request->id;
    	$model = Drawing::find($id);
    	if(!$model)
    	{
    		$this->error_message('数据不存在');
    	}
    	$drawing = Drawing::where('house_id',$model->house_id)->where('name',$name)->first();
    	if(!empty($drawing) && $drawing->id != $model->id)
    	{
    		$this->error_message('图纸已存在');
    	}
    	$model->name = $name;
    	$model->save();
    	$this->success_message('修改成功');
    }
    public function drawing_del(Request $request)
    {
    	$id = $request->id;
    	if(!is_array($id))
    	{
    		$id = array($id);
    	}
    	foreach($id as $v)
    	{
    		$model = Drawing::find($v);
    		if($model)
    		{
    			@unlink('.'.$model->dwg_image);
    			@unlink('.'.$model->effect_image);
    			$model = null;
    		}
    	}
    	Drawing::destroy($id);
    	$this->success_message('删除成功');
    }
    public function drawing_upload(Request $request)
    {	
    	$id = $request->id;
		$model = Drawing::find($id);
		if(!$model)
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
                $newName = $model->name.mt_rand(1111,9999).'.'.$extension;
                $url = $request->dwg_upload->storeAs('/design/drawing/dwg',$newName,'upload');
                if($url)
                {   
                    $image = $model->dwg_image;
                    $path = env('UPLOAD').'/'.$url;
                    $model->dwg_image = $path;
                    $res = $model->save();
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
                $newName = $model->name.mt_rand(1111,9999).'.'.$extension;
                $url = $request->effect_image->storeAs('/design/drawing/image',$newName,'upload');
                if($url)
                {   
                    $image = $model->effect_image;
                    $path = env('UPLOAD').'/'.$url;
                    $model->effect_image = $path;
                    $res = $model->save();
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

    public function drawing_download(Request $request)
    {   
    	$model = Drawing::find($request->a);
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
}
