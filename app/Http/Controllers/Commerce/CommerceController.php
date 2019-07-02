<?php

namespace App\Http\Controllers\Commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Company;
use App\Model\Developer\Project;
class CommerceController extends Controller
{
    function company(Request $request)
    {
    	if($request->isMethod('get'))
    	{  
    		return view('Commerce.Commerce.company',[
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
    public function project(Request $request)
    {	
    	if($request->isMethod('get'))
    	{	
    		$company = Company::where('status','>',0)->get();
    		return view('Commerce.Commerce.project',[
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
                $data[$k]['is_sales_re'] = $v['is_sales']?'是':'否';
                $data[$k]['is_hardcover_re'] = $v['is_hardcover']?'是':'否';
		    	$data[$k]['company_name'] = $v['company']['company_name'];
		    }
    		$total = Project::where('name','like','%'.$name.'%')
                    ->where('status','>',0)
                    ->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }
}
