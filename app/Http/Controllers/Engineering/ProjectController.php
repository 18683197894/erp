<?php

namespace App\Http\Controllers\Engineering;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;
use App\Model\Design\Huxing;
use App\Model\Engineering\Schedule;
use App\Model\Customer\Schedule as CustomerSchedule;
use App\Model\Engineering\Album;
use App\Model\Engineering\Demand;

class ProjectController extends Controller
{
	public function project(Request $request)
	{
		if($request->isMethod('get'))
		{	
            $project = Project::where('status','2')->get();
			return view('Engineering.Project.project',[
                'project' => $project
			]);
		}else
		{   
			$data = House::select('*')
                    ->with(['Project'=>function($query){
                        return $query->select('id','name')->get();
                    },'Huxing'=>function($query){
                        return $query->select('id','name')->get();
                    }])
                    ->where([
                        ['status','>',0],
                        ['project_id','like','%'.$request->get('project_id','').'%'],
                        ['building','like','%'.$request->get('building','').'%'],
                        ['unit','like','%'.$request->get('unit','').'%'],
                        ['floor','like','%'.$request->get('floor','').'%']
                    ])
                    ->offset(($request->page - 1) * $request->limit)
                    ->limit($request->limit)
                    ->get();
            $total = House::select('*')
                    ->where([
                        ['status','>',0],
                        ['project_id','like','%'.$request->get('project_id','').'%'],
                        ['building','like','%'.$request->get('building','').'%'],
                        ['unit','like','%'.$request->get('unit','').'%'],
                        ['floor','like','%'.$request->get('floor','').'%']
                    ])
                    ->count();
            foreach($data as $k => $v)
            {
                $data[$k]->project_name = $v->Project->name;
                if($v->Huxing)
                {
                    $data[$k]->huxing_name = $v->Huxing->name;
                }
            }
            $this->tableData($total,$data,'获取成功',0);
		}
	}
    public function project_edit(Request $request)
    {
    	$data = $request->except('_token');
    	House::where('id',$data['id'])->update($data);
    	$this->success_message('修改成功');
    }
	public function house(Request $request)
	{
		if($request->isMethod('get'))
		{	
            $project = Project::where('status','=',2)->get();
			return view('Engineering.Project.house',[
                'project' => $project
			]);
		}else
		{
			$data = House::select('*')
                    ->with(['Schedules'=>function($query){
                        return $query->select('id','house_id','details','serial_number')->orderBy('serial_number','DESC')->get();
                    },'Huxing'=>function($query){
                        return $query->select('id','name')->get();
                    },'Project'=>function($query){
                        return $query->select('id','name')->get();
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

		    foreach ($data as $key => $value) 
		    {   
                $data[$key]['project_name'] = $value['project']['name'];
                if(isset($value['schedules'][0]))
                {   
                    
                    $data[$key]['schedule_name'] = $value['schedules'][0]['details'];
                }else
                {
                    $data[$key]['schedule_name'] = '未开工';
                }
		    	if($value['huxing'])
		    	{
		    		$data[$key]['huxing_name'] = $value['huxing']['name'];
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
                    $details = $value['schedule']['details'];
                    $data[$key]['schedule_name'] = $details;
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
