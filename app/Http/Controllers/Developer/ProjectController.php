<?php

namespace App\Http\Controllers\Developer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Developer\Company;
use App\Model\Developer\ProjectContacts;
use App\Model\Developer\ProjectInformation;
use App\Model\Developer\Appointment;
use App\Model\Developer\Feedback;
use App\Model\Sys\User;
class ProjectController extends Controller
{
    public function project(Request $request)
    {	
    	if($request->isMethod('get'))
    	{	
    		$company = Company::where('status','>',0)->get();
    		return view('Developer.Project.project',[
    			'request' => $request->all(),
    			'company' => $company
    		]);
    	}else
    	{
			$name = $request->post('name',false)?$request->name:'';
    		$data = Project::where('name','like','%'.$name.'%')
    				->with('Company')
    				->with(['Appointments'=>function($query){
    					return $query->select('project_id','id','schedule')->where('status','>',0)->orderBy('time','DESC')->get();
    				}])
                    ->where('status','>=',0)
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
		    foreach($data as $k => $v)
		    {	
		    	if(!$v['appointments'])
		    	{
		    		$data[$k]['schedule'] = '无';
		    	}else
		    	{
		    		$data[$k]['schedule'] = $v['appointments'][0]['schedule'];
		    	}
		    	$data[$k]['company_name'] = $v['company']['company_name'];
		    }
    		$total = Project::where('name','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }
    public function project_add(Request $request)
    {
    	$data = $request->except('_token','province');
    	$data['prov'] = $request->province;
    	if(Project::where('re_address',$data['re_address'])->where('name',$data['name'])->first())
    	{
    		$this->error_message('项目已存在');
    	}
    	if(Project::create($data))
    	{
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
        $model = Project::find($request->id);
        if($model)
        {   
            if($model->status == 2)
            {
                $this->error_message('已禁止删除');
            }
            Project::where('id',$request->id)->delete();
            ProjectContacts::where('project_id',$request->id)->delete();
            ProjectInformation::where('project_id',$request->id)->delete();
            $appointment = Appointment::where('project_id',$request->id)->get();
            if($appointment)
            {
                foreach($appointment as $v)
                {
                    Appointment::where('id',$v->id)->delete();
                    Feedback::where('appointment_id',$v->id)->delete();
                }
            }
        }
        
        $this->success_message('删除成功');
    }

    public function contacts(Request $request)
    {   
        if($request->isMethod('get'))
        {      
            // $urls = parse_url(\url()->previous());
            $project = Project::find($request->project_id);
            if(!$project)
            {
                return back();
            }
            return view('Developer.Project.contacts',[
                'project' => $project,
                'title' => $project->name
                // 'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $name = $request->post('name',false)?$request->name:'';
            $data = ProjectContacts::where('project_id',$request->project_id)
                    ->where('name','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            $total = ProjectContacts::where('project_id',$request->project_id)
                            ->where('status','>',0)
                            ->where('name','like','%'.$name.'%')
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
    }
    public function contacts_add(Request $request)
    {
        $data = $request->except('_token');
        $data['status'] = 1;
        $company = Project::find($data['project_id']);
        if(!$company)
        {
            $this->error_message('项目不存在');
        }
        if(ProjectContacts::where('name',$data['name'])->where('project_id',$data['project_id'])->first())
        {
            $this->error_message('该联系人已存在');
        }
        if(ProjectContacts::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('新增失败');
        }
    }

    public function contacts_edit(Request $request)
    {
        $data = $request->except('_token');
        $contacts = ProjectContacts::find($data['id']);
        if(!$contacts)
        {
            $this->error_message('联系人不存在');
        }
        $oldName = ProjectContacts::where('name',$data['name'])->where('project_id',$contacts->project_id)->first();
        if($oldName && $oldName->id != $contacts->id)
        {
            $this->error_message('联系人已存在');
        }
        ProjectContacts::where('id',$contacts->id)->update($data);
        $this->success_message('修改成功');
    }
    public function contacts_del(Request $request)
    {   
        $id = $request->id;
        if(!is_array($request->id))
        {
            $id = array($request->id);
        }
		ProjectContacts::destroy($id);
        return $this->success_message('删除成功');

    }

    public function information(Request $request)
    {
        if($request->isMethod('get'))
        {
            // $urls = parse_url(\url()->previous());
            $project = Project::find($request->project_id);
            if(!$project)
            {
                return back();
            }
            return view('Developer.Project.information',[
                'project' => $project,
                'title' => $project->name
                // 'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $title = $request->post('name',false)?$request->name:'';
            $data = ProjectInformation::where('project_id',$request->project_id)
                    ->where('title','like','%'.$title.'%')
                    ->where('status','>',0)
                    ->orderBy('time','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            $total = ProjectInformation::where('project_id',$request->project_id)
                            ->where('status','>',0)
                            ->where('title','like','%'.$title.'%')
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }

    }

    public function information_add(Request $request)
    {
        $data = $request->except('_token');

        if(ProjectInformation::where('title',$data['title'])->where('project_id',$data['project_id'])->first())
        {
            $this->error_message('标题已存在');
        }

        if(ProjectInformation::create($data))
        {
            $this->success_message('新增成功');
        }else
        {
            $this->error_message('新增失败');
        }
    }

    public function information_edit(Request $request)
    {   

        $data = $request->except('_token');
        $oldName = ProjectInformation::find($data['id']);
        if(!$oldName)
        {
            $this->error_message('信息不存在');
        }

        $title = ProjectInformation::where('title',$data['title'])->where('project_id',$oldName->project_id)->first();

        if($title && $title->id != $oldName->id)
        {
            $this->error_message('标题已存在');
        }
        ProjectInformation::where('id',$oldName->id)->update($data);
        $this->success_message('修改成功');
    }

    public function information_del(Request $request)
    {   
        $id = $request->id;
        if(!is_array($request->id))
        {
            $id = array($request->id);
        }
        ProjectInformation::destroy($id);
        return $this->success_message('删除成功');

    }

    public function appointment(Request $request)
    {
    	if($request->isMethod('get'))
        {   
        	$user = User::where('status','>',0)->get();
            // $urls = parse_url(\url()->previous());
            $project = Project::find($request->project_id);
            if(!$project)
            {
                return back();
            }
            return view('Developer.Project.appointment',[
                'project' => $project,
                'user'	=> $user,
                'title' => $project->name
                // 'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $data = Appointment::where('project_id',$request->project_id)
                    ->where('status','>',0)
                    ->with(['User'=>function($query){
                    	return $query->select('id','username')->get();
                    }])
                    ->with('Feedback')
                    ->orderBy('time')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
                   
            foreach($data as $k => $v)
            {
            	$data[$k]['contact_seniors'] = !empty($v['contact_senior'])?'是':'否';
            	$data[$k]['advances'] = !empty($v['advance'])?'是':'否';
            	$data[$k]['username'] = $v['user']['username'];
            }
            $total = Appointment::where('project_id',$request->project_id)
                            ->where('status','>',0)
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
    }
	public function appointment_add(Request $request)
	{	
		$data = $request->except('_token');
		if(date('Y-m-d',time()) > $data['time'])
		{
			$this->error_message('请从新选择拜访时间');
		}
		$data['advance'] = isset($data['advance'])?1:0;
		$data['contact_senior'] = isset($data['contact_senior'])?1:0;
		if(Appointment::create($data))
		{
			$this->success_message('新增成功');
		}else
		{
			$this->success_message('新增失败');
		}
	}

	public function appointment_edit(Request $request)
	{
		$data = $request->except('_token');
		$data['advance'] = isset($data['advance'])?1:0;
		$data['contact_senior'] = isset($data['contact_senior'])?1:0;
		if(date('Y-m-d',time()) > $data['time'])
		{
			$this->error_message('请从新选择拜访时间');
		}
		if(Feedback::where('appointment_id',$data['id'])->first() && \session('user')['type'] != 10)
		{
			$this->error_message('已禁止编辑');
		}
		Appointment::where('id',$data['id'])->update($data);
		$this->success_message('修改成功');
	}

	public function feedback_add(Request $request)
	{   
        $data['id'] = $request->id;
		$data = $request->except('_token');
		$data['higher_team'] = isset($data['higher_team'])?1:0;
		$data['higher_post'] = isset($data['higher_post'])?1:0;
		$appointment = Appointment::find($data['appointment_id']);
		if(date('Y-m-d',time()) < $appointment->time && \session('user')['type'] != 10)
		{
			$this->error_message('已禁止反馈');
		}
		if(!$appointment)
		{
			$this->error_message('反馈失败');
		}
		if(\session('user')['type'] !== 10)
		{
			if($appointment->id !== \session('user')['id'])
			{
				$this->error_message('非负责人无法反馈');
			}
		}
		if($data['id'])
		{     
            Feedback::where('id',$data['id'])->update($data);
            $this->success_message('反馈成功');
		}else
        {   
            unset($data['id']);
            if(Feedback::create($data))
            {
                $this->success_message('反馈成功');
            }else
            {
                $this->error_message('反馈失败');
            }
        }



	}

	public function appointment_del(Request $request)
	{
		$id = $request->id;
		Appointment::destroy($id);
		Feedback::where('appointment_id',$id)->delete();
		return $this->success_message('删除成功');
	}

    public function screening(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('Developer.Project.screening');
        }else
        {
            $data = Project::select('developer_project.name','developer_project.source','developer_project.screening_time','developer_project.status','developer_project.id','developer_company.company_name')
            ->join('developer_company',function($join){
                $join->on('developer_project.company_id','=','developer_company.id');
            })
            ->where('developer_project.status','>=',0)
            ->orderBy('developer_project.created_at','DESC')
            ->offset(($request->page - 1) * $request->limit)
            ->limit($request->limit)
            ->get();
            foreach($data as $k => $v)
            {
                if($data[$k]['screening_time'])
                {
                    $data[$k]['status'] = $v['status']?'有效':'无效'; 
                }else
                {
                    $data[$k]['status'] = '';
                }
            }
            $total = Project::select('developer_project.name','developer_company.company_name')
                ->join('developer_company',function($join){
                    $join->on('developer_project.company_id','=','developer_company.id');
                })
                ->where('developer_project.status','>=',0)
                ->count();
            $this->tableData($total,$data,'获取成功',0);
        }
    }

    public function screening_edit(Request $request)
    {
        $model = Project::find($request->id);
        if(!$model) $this->error_message('数据不存在');

        if($model->status < 2)
        {
            $model->status = $request->status === 'on'?1:0;
        }
        $model->source = $request->source;
        $model->screening_time = time();
        $model->save();
        $this->success_message("编辑成功");
    }

    public function summary(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('Developer.Project.summary');
        }else
        {
            $data = Project::select('*')
                    ->with('Company')
                    ->with(['Appointments'=>function($query){
                        return $query->select('id','project_id','schedule')
                                    ->where('status','>','0')
                                    ->orderBy('time','DESC');
                    }])
                    ->where('status','>=',0)
                    ->offset(($request->page - 1) * $request->limit)
                    ->limit($request->limit)
                    ->orderBy('created_at','DESC')
                    ->get();
            foreach($data as $k => $v)
            {
                $data[$k]->company_name = $v->company->company_name;
                $data[$k]->appointments_name = $v->appointments[0]->schedule;
                $data[$k]->remarks = $v->appointments[0]->remarks;
                $data[$k]->user_name = User::find($v->appointments[0]->user_id)->username;
                if($v->appointments[0]->feedback)
                {
                    $data[$k]->now_result = $v->appointments[0]->feedback->now_result;
                    $data[$k]->next_stage = $v->appointments[0]->feedback->next_stage;
                }
            }
            $total = Project::select('*')
                    ->where('status','>=',0)
                    ->count();
            $this->tableData($total,$data,'获取成功',0);

        }
    }
}
