<?php

namespace App\Http\Controllers\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;
use App\Model\Design\Drawing;
class ManageController extends Controller
{
    public function manage(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$project = Project::where('status',2)->get();
             $houses = House::where('is_template',1)->with('Project')->get();
    		return view('Design.Manage.manage',[
                'project'=>$project,
                'houses' => $houses,
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
                    },'Project'=>function($query){
                        return $query->select('id','name')->get();
                    },'Demand'=>function($query){
                        return $query->select('id','arrangement','style','like','demand','house_id')->get();
                    },'Template'=>function($query){
                        return $query->select('id','project_id','room_number','floor','building','unit')
                            ->with(['Project'=>function($query){
                        return $query->select('id','name')->get();
                            }])
                            ->get();
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
                if($v['template'])
                {
                    $data[$k]['template_name'] = $v['template']['project']['name'].$v['building'].'栋'.$v['unit'].'单元'.$v['floor'].'层'.$v['room_number'].'号';
                }
                if($v['is_template'] == 1)
                {
                    $data[$k]['template_name'] = '样板房';
                }
                $data[$k]['count'] = bcadd(bcadd($v['manual_cost'],$v['manual_sale_cost'],2),bcadd($v['material_cost'],$v['construction_cost'],2),2);
                if($data[$k]['count'] <= 0)
                {   
                    $data[$k]['count'] = '';
                }
                
            }
            $total = House::where('room_number','like','%'.$room_number.'%')
                    ->where('project_id','like','%'.$project_id.'%')
                    ->where('status','>',0)
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
    	}
    }                       
    public function manage_edit(Request $request)
    {
        if($request->isMethod('get'))
        {
            $model = House::find($request->house_id);
            if(!$model) die('数据不存在');
            $houses = House::where('is_template',1)->where('id','!=',$model->id)->with('Project')->get();
            return view('Design.Manage.edit',[
                'model'=>$model,
                'houses' => $houses
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
            if($model->is_template == 1 && $request->post('template_id',null))
            {
                $this->error_message('样板房无法绑定样板套装');
            }
            House::where('id',$data['id'])->update($data);
            $this->success_message('修改成功');
        }
    }
    public function drawing(Request $request)
    {
        if($request->isMethod('get'))
        {   
            $house = House::find($request->house_id);
            if(!$house)
            {
                die('数据不存在');
            }
            return view('Design.Manage.drawing',[
                'house'=>$house
            ]);
        }else
        {
            $house_id = $request->house_id;
            $data = Drawing::select('*')
                    ->where('house_id',$house_id)
                    ->where('status','>',0)
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();

            $total = Drawing::where('status','>',0)
                            ->where('house_id',$house_id)
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
