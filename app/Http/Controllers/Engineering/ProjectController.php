<?php

namespace App\Http\Controllers\Engineering;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;
use App\Model\Engineering\Huxing;
use App\Model\Engineering\Schedule;
use App\Model\Customer\Schedule as CustomerSchedule;
use App\Model\Engineering\Album;
class ProjectController extends Controller
{
	public function project(Request $request)
	{
		if($request->isMethod('get'))
		{	
            $project = Project::where('status','1')->where('label','已完成')->get();
			return view('Engineering.Project.project',[
				'request' => $request->all(),
                'project' => $project
			]);
		}else
		{
			$name = $request->post('name',false)?$request->name:'';
			$data = Project::where('name','like','%'.$name.'%')
	                ->where('status',2)
                    ->with('Houses')
					->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
            foreach($data as $k => $v)
            {
                $data[$k]['fangshu'] = count($v['houses']);
                $data[$k]['acreage'] = 0;
                foreach($v['houses'] as $key => $val)
                {
                    $data[$k]['acreage'] += !empty($val['acreage'])?$val['acreage']:0;
                }
            }
			$total = Project::where('name','like','%'.$name.'%')
	                ->where('status',2)
	                ->count();
			$this->tableData($total,$data,'获取成功',0);
		}
	}
    public function project_add(Request $request)
    {
    	$data = $request->except('_token','province');
        $model = Project::find($request->project_id);
    	if($model)
    	{   
            $model->status = 2;
            $model->admission_time = $request->admission_time;
            $model->estimate_time = $request->estimate_time;
            $model->save();
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }

    public function project_edit(Request $request)
    {
    	$data = $request->except('_token','province');
    	$data['prov'] = $request->province;
    	$oldProject = Project::where('re_address',$data['re_address'])->where('name',$data['name'])->first();
    	$newProject = Project::find($data['id']);
    	if($oldProject && $oldProject->id != $newProject->id)
    	{
    		$this->error_message('项目已存在');
    	}

    	Project::where('id',$data['id'])->update($data);
    	$this->success_message('修改成功');
    }

    public function project_del(Request $request)
    {
        $id = $request->id;
        $model = Project::find($id);
        if($model)
        {   
            if(House::where('project_id',$id)->where('status','!=',-1)->get()->count() > 0)
            {
                $this->error_message('已禁止删除');
            }
            $huxing = Huxing::where('project_id',$id)->get();
            foreach($huxing as $v)
            {
                @unlink('.'.$v->dwg_image);
                @unlink('.'.$v->effect_image);
            }
            Huxing::where('project_id',$id)->delete();
            $model->status = 1;
            $model->admission_time = null;
            $model->estimate_time = null;
            $model->save();
            $this->success_message('删除成功');
        }
        $this->success_message('删除成功');
    }
	public function house(Request $request)
	{
		if($request->isMethod('get'))
		{	
			$huxing = Huxing::where('status','>',0)->get();
            $urls = parse_url(\url()->previous());
            $project = Project::find($request->project_id);
			return view('Engineering.Project.house',[
				'request' => $request->all(),
				'huxing' => $huxing,
                'title' => $project->name,
                'project' => $project,
				'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
			]);
		}else
		{
			$room_number = $request->post('name',false)?$request->name:'';
			$data = House::where('room_number','like','%'.$room_number.'%')
	                ->where('status','>',0)
	                ->with('Huxing')
                    ->with(['Schedules'=>function($query){
                        return $query->orderBy('serial_number','DESC')->get();
                    }])
					->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
		    foreach ($data as $key => $value) 
		    {     
                if(isset($value['schedules'][0]))
                {   
                    $details = !empty($value['schedules'][0]['details'])?'-'.$value['schedules'][0]['details']:'';
                    $data[$key]['schedule_name'] = $value['schedules'][0]['stage'].'-'.$value['schedules'][0]['matter'].$details;
                }else
                {
                    $data[$key]['schedule_name'] = '未开工';
                }
		    	if($value['huxing'])
		    	{
		    		$data[$key]['huxing_name'] = $value['huxing']['name'];
		    	}else
		    	{
		    		$data[$key]['huxing_name'] = '无';
		    	}
		    }
			$total = House::where('room_number','like','%'.$room_number.'%')
	                ->where('status','>',0)
	                ->count();
			$this->tableData($total,$data,'获取成功',0);
		}
	}
	public function huxing(Request $request)
	{
       if($request->isMethod('get'))
        {
            $urls = parse_url(\url()->previous());
            $project = Project::find($request->project_id);
            if(!$project)
            {
                return back();
            }
            return view('Engineering.Project.huxing',[
                'project' => $project,
                'title' => $project->name,
                'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $name = $request->post('name',false)?$request->name:'';
            $data = Huxing::where('project_id',$request->project_id)
                    ->where('name','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            $total = Huxing::where('project_id',$request->project_id)
                            ->where('status','>',0)
                            ->where('name','like','%'.$name.'%')
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
	}

	public function huxing_add(Request $request)
	{
		$name = $request->name;
		$project_id = $request->project_id;
		if(Huxing::where('name',$name)->first())
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
		$name = $request->name;
		$huxing = Huxing::find($request->id);
		$oldName = Huxing::where('name',$name)->where('project_id',$request->project_id)->first();
		if($oldName && $oldName->id != $huxing->id)
		{
			$this->error_message('户型已存在');
		}
		$huxing->name = $name;
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
                $url = $request->dwg_upload->storeAs('/engineering/project/huxing/dwg',$newName,'upload');
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
                $url = $request->effect_image->storeAs('/engineering/project/huxing/image',$newName,'upload');
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
        $data = $request->except('_token');
        $model = House::find($data['id']);
        if(!$model)
        {
            $this->error_message('数据不存在');
        }
        $oldHouse = House::where('room_number',$data['room_number'])->where('floor',$data['floor'])->where('building',$data['building'])->where('unit',$data['unit'])->where('project_id',$model->project_id)->first();
        if($oldHouse->id && $oldHouse->id != $model->id)
        {
            $this->error_message('当前房号已存在');
        }
        House::where('id',$data['id'])->update($data);
        $this->success_message('修改成功');
    }
    public function house_del(Request $request)
    {
        $id = $request->id;
        $model = House::find($id);
        if($model)
        {
            Schedule::where('house_id',$id)->delete();
            CustomerSchedule::where('house_id',$model->id)->delete();
            $album = Album::where('house_id',$id)->get();
            foreach($album as $v)
            {
                @unlink('.'.$v->image);
                @unlink('.'.$v->re_image);
            }
            Album::where('house_id',$id)->delete();
            House::where('id',$id)->delete();
        }
        $this->success_message('删除成功');
    }
    public function schedule(Request $request)
    {
        $house = House::find($request->house_id);
        $schedule = Schedule::where('house_id',$house->id)->orderBy('serial_number')->get();
        if(!$house) die('数据不存在');
        return view('Engineering.Project.schedule',[
            'house'=>$house,
            'schedule'=>$schedule
        ]);
    }

    public function schedule_add(Request $request)
    {
        $data = $request->except('_token');

        $house = House::find($data['house_id']);
        sleep(1);
        $house_schedule = Schedule::where('house_id',$data['house_id'])->where('serial_number',$data['serial_number'])->first();
        if(!empty($data['end']) && $data['start'] > $data['end']) $this->error_message('结束时间大于开工时间',$house_schedule);
        if(!$house) return $this->error_message('房间号不存在',$house_schedule);
        $model = Schedule::where('house_id',$data['house_id'])->where('status',2)->where('serial_number',(intval($data['serial_number']) - 1))->first();           
        if($data['serial_number'] != 1 && !$model) $this->error_message('提交失败 不能越级更新进度',$house_schedule);
        
        if($data['serial_number'] != 1 && $data['start'] < $model->end) $this->error_message('提交失败 开始时间小于上阶段结束时间',$house_schedule);
        $status = 1;

        if(!empty($data['start']) && !empty($data['end']) && !empty($data['liable']) && !empty($data['check']))
        {
            $data['status'] = 2;
            $status = 2;
        }
        if($house_schedule)
        {   
            unset($data[0]);
            if($house_schedule->status == 2 && \session('user')['type'] != 10)
            {
                $this->error_message('已禁止编辑',$house_schedule);
            }
            Schedule::where('id',$house_schedule->id)->update($data);
        }else
        {   
            if($data['serial_number'] == 40)
            {
                $house->schedule = 1;
                $house->save();
            }
            Schedule::create($data);
        }
        $this->success_message('提交成功',$status);
    }

    public function album(Request $request)
    {   
        if($request->isMethod('get'))
        {   
            $house = House::find($request->house_id);
            $schedule = Schedule::where('house_id',$request->house_id)->orderBy('serial_number')->get();
            return view('Engineering.Project.album',[
                'house'=>$house,
                'schedule'=>$schedule
            ]);
            
        }else
        {   
            $schedule_id = $request->post('schedule_id','');
            $data = Album::where('status','>',0)
                    ->where('schedule_id','like','%'.$schedule_id.'%')
                    ->where('house_id',$request->house_id)
                    ->with('Schedule')
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            foreach ($data as $key => $value) 
            {     
                if(!empty($value['schedule']))
                {   
                    $details = !empty($value['schedule']['details'])?'-'.$value['schedule']['details']:'';
                    $data[$key]['schedule_name'] = $value['schedule']['stage'].'-'.$value['schedule']['matter'].$details;
                }else
                {
                    $data[$key]['schedule_name'] = '无';
                }
                
            }
            $total = Album::where('status','>',0)
                    ->where('schedule_id','like','%'.$schedule_id.'%')
                    ->where('house_id',$request->house_id)
                    ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
    }

    public function album_add(Request $request)
    {
        $data = $request->except('_token');
        if($request->hasFile('image'))
        {
            if($request->file('image')->isValid())
            {
                $extension = $request->image->extension();
                if($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png')
                {
                    $this->error_message('请上传图片');
                }
                $newName = time().mt_rand(1111,9999).'.'.$extension;
                $url = $request->image->storeAs('/engineering/project/album',$newName,'upload');
                if($url)
                {   
                    $path = env('UPLOAD').'/'.$url;
                    $data['image'] = $path;
                    $data['re_image'] = env('UPLOAD').'/engineering/project/album/'.'re_'.$newName;
                    
                    \Image::make('.'.$data['image'])->resize(300,200)->save('.'.$data['re_image']);
                    \Image::make('.'.$data['image'])->insert('.'.env('IMAGE_SHUIYING'),'bottom-right',20,20)->save();
                   if(Album::create($data))
                   {
                    $this->success_message('新增成功');
                   }else
                   {
                    @unlink('.'.$data['image']);
                    @unlink('.'.$data['re_image']);
                    $this->error_message('新增失败');
                   }
                }
            }
        }
        $this->error_message('新增失败');
    }
    public function album_edit(Request $request)
    {
        $data = $request->except('_token');
        if(Album::find($data['id']))
        {
            Album::where('id',$data['id'])->update($data);
            $this->success_message('编辑成功');
        }else
        {
            $this->error_message('数据不存在');
        }
    }
    public function album_del(Request $request)
    {
        $id = $request->id;
        if(!is_array($id))
        {
            $id = array($id);
        }
        foreach($id as $v)
        {
            $model = Album::find($v);
            if($model)
            {
                @unlink('.'.$model->image);
                @unlink('.'.$model->re_image);
            }
        }
        Album::destroy($id);
        $this->success_message('删除成功');
    }

    public function album_check(Request $request)
    {   
        $schedule_id = $request->get('schedule_id','');
        $data = Album::where('status','>',0)
        ->where('schedule_id','like','%'.$schedule_id.'%')
        ->where('house_id',$request->house_id)
        ->with('Schedule')
        ->orderBy('created_at','DESC')
        ->offset(($request->page -1) * $request->limit)
        ->limit($request->limit)
        ->get()
        ->toArray();
        $phone = array();
        $phone['title'] = '相册';
        $phone['id'] = 1;
        $phone['start'] = 0;
        $phone['data'] = array();
        foreach($data as $k => $v)
        {
            $tmp = array();
            $details = !empty($v['schedule']['details'])?'-'.$v['schedule']['details']:'';
            $tmp['alt'] = $v['schedule']['stage'].'-'.$v['schedule']['matter'].$details;
            $tmp['pid'] = $v['id'];
            $tmp['src'] = $v['image'];
            $tmp['thumb'] = $v['re_image'];
            $phone['data'][$k] = $tmp;     
            if($v['id'] == $request->album_id)
            {
                $phone['start'] = $k;
            }     
        }
        return response()->json($phone);
    }
}
