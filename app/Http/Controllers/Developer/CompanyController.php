<?php

namespace App\Http\Controllers\Developer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Company;
use App\Model\Developer\Contacts;
use App\Model\Developer\Information;

use App\Model\Developer\Project;
use App\Model\Developer\ProjectContacts;
use App\Model\Developer\ProjectInformation;
use App\Model\Developer\Appointment;
use App\Model\Developer\Feedback;
class CompanyController extends Controller
{
    function company(Request $request)
    {
    	if($request->isMethod('get'))
    	{  
    		return view('Developer.Company.company',[
                'request' => $request->all()
            ]);
    	}else if($request->isMethod('post'))
    	{
			$company_name = $request->post('company_name',false)?$request->company_name:'';
    		$data = Company::where('company_name','like','%'.$company_name.'%')
                    ->where('status','>',0)
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
    		$total = Company::where('company_name','like','%'.$company_name.'%')
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function company_add(Request $request)
    {	
    	$data = $request->except('_token');
        $data['status'] = 1;
    	if(Company::where('company_name',$data['company_name'])->first())
    	{
    		$this->error_message('公司已存在');
    	}
    	if(Company::create($data))
    	{
    		$this->success_message('录入成功');
    	}else
    	{
    		$this->error_message('录入失败');
    	}
    }

    public function company_edit(Request $request)
    {
    	$model = Company::find($request->id);
    	if(!$model)
    	{  
    		$this->error_message('数据不存在');
    	}

    	if($request->company_name && $request->company_address)
    	{
    		$model->company_name = $request->company_name;
    		$model->company_address = $request->company_address;
    		$model->save();
    	}
    	$this->success_message('编辑成功');
    }

    public function company_del(Request $request)
    {   
        $model = Company::find($request->id);
        if($model)
        {   
            if($model->Projects->count() > 0)
            {
                $this->error_message('已禁止删除');
            }
            Company::where('id',$request->id)->update(['status'=>-1]);
            Contacts::where('company_id',$request->id)->update(['status'=>-1]);
            Information::where('company_id',$request->id)->update(['status'=>-1]);      
        }
        $this->success_message('删除成功');
    }
    public function contacts(Request $request)
    {   
        if($request->isMethod('get'))
        {      
            $urls = parse_url(\url()->previous());
            $company = Company::find($request->company_id);
            if(!$company)
            {
                return back();
            }
            return view('Developer.Company.contacts',[
                'company' => $company,
                'title' => $company->company_name,
                'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $name = $request->post('name',false)?$request->name:'';
            $data = Contacts::where('company_id',$request->company_id)
                    ->where('name','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            $total = Contacts::where('company_id',$request->company_id)
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
        $company = Company::find($data['company_id']);
        if(!$company)
        {
            $this->error_message('开发商不存在');
        }
        if(Contacts::where('name',$data['name'])->where('company_id',$data['company_id'])->first())
        {
            $this->error_message('该联系人已存在');
        }
        if(Contacts::create($data))
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
        $contacts = Contacts::find($data['id']);
        if(!$contacts)
        {
            $this->error_message('联系人不存在');
        }
        $oldName = Contacts::where('name',$data['name'])->where('company_id',$contacts->company_id)->first();
        if($oldName && $oldName->id != $contacts->id)
        {
            $this->error_message('联系人已存在');
        }
        Contacts::where('id',$contacts->id)->update($data);
        $this->success_message('修改成功');
    }

    public function contacts_del(Request $request)
    {   
        $id = $request->id;
        if(!is_array($request->id))
        {
            $id = array($request->id);
        }
        Contacts::destroy($id);

        return $this->success_message('删除成功');

    }

    public function information(Request $request)
    {
        if($request->isMethod('get'))
        {
            $urls = parse_url(\url()->previous());
            $company = Company::find($request->company_id);
            if(!$company)
            {
                return back();
            }
            return view('Developer.Company.information',[
                'company' => $company,
                'title' => $company->company_name,
                'url' => $urls['scheme'].'://'.$urls['host'].$urls['path'].$this->baseKey($request->all())
            ]);
        }else if($request->isMethod('post'))
        {
            $title = $request->post('name',false)?$request->name:'';
            $data = Information::where('company_id',$request->company_id)
                    ->where('title','like','%'.$title.'%')
                    ->where('status','>',0)
                    ->orderBy('time','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            $total = Information::where('company_id',$request->company_id)
                            ->where('status','>',0)
                            ->where('title','like','%'.$title.'%')
                            ->count();
            $this->tableData($total,$data,'获取成功',0);
        }

    }
    public function information_add(Request $request)
    {
        $data = $request->except('_token');

        if(Information::where('title',$data['title'])->where('company_id',$data['company_id'])->first())
        {
            $this->error_message('标题已存在');
        }

        if(Information::create($data))
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
        $oldName = Information::find($data['id']);
        if(!$oldName)
        {
            $this->error_message('信息不存在');
        }

        $title = Information::where('title',$data['title'])->where('company_id',$oldName->company_id)->first();

        if($title && $title->id != $oldName->id)
        {
            $this->error_message('标题已存在');
        }
        Information::where('id',$oldName->id)->update($data);
        $this->success_message('修改成功');
    }
    public function information_del(Request $request)
    {   
        $id = $request->id;
        if(!is_array($request->id))
        {
            $id = array($request->id);
        }

        Information::destroy($id);
        return $this->success_message('删除成功');

    }
}
