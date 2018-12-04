<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\PowerRule;
use App\Model\Sys\PowerCate;
use App\Model\Sys\PowerRole;
use App\Model\Sys\PowerRoleRule;
class PowerController extends Controller
{
    public function rule(Request $request)
    {	
    	if($request->isMethod('get'))
    	{	
	        $app = app();
	        $routes = $app->routes->getRoutes();
	        $path = [];
	        foreach ($routes as $k=>$value)
	        {
	            if( isset($value->action['middleware']) && in_array('rule',$value->action['middleware']))
	            {	
	            	if($value->uri == '/')
	            	{
	            		continue;
	            	}
	                $path[$k] = '/'.$value->uri;
	            }
	        }
    		$cate = PowerCate::orderBy('created_at','DESC')->get();
			return view('Sys.Power.rule',[
				'cate' => $cate,
				'path' => $path
			]);
    	}else if($request->isMethod('post'))
    	{	
    		$rule_name = $request->post('rule_name',false)?$request->rule_name:'';
    		$data = PowerRule::where('rule_name','like','%'.$rule_name.'%')
    				->with('Cate')
                    ->orderBy('cate_id','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
		    		// dd($data);
		   	foreach($data as $k => $v)
		   	{
		   		if(!empty($v['cate']))
		   		{
		   			$data[$k]['cate_name'] = $v['cate']['cate_name'];
		   		}else
		   		{
		   			$data[$k]['cate_name'] = '无';
		   		}
		   	}
    		$total = PowerRule::where('rule_name','like','%'.$rule_name.'%')->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}

    }

    public function rule_edit(Request $request)
    {
    	$model = PowerRule::find($request->id);
    	if($model)
    	{
    		$model->rule_name = $request->rule_name;
    		$model->save();
    		$this->success_message('修改成功');
    	}else
    	{
    		$this->error_message('数据不存在 请刷新页面');
    	}
    }

    public function rule_del(Request $request)
    {	
    	$id = $request->id;
    	if(!is_array($id))
    	{
    		$id = array($id);
    	}
        foreach($id as $v)
        {
            PowerRoleRule::where('rule_id',$v)->delete();
        }
    	PowerRule::destroy($id);
    	$this->success_message('删除成功');
    }

    public function rule_add(Request $request)
    {
    	$data = $request->except('_token');
    	$model = PowerCate::find($data['cate_id']);
    	if(!$model)
    	{
    		$this->error_message('权限分类不存在');
    	}
    	$rule = PowerRule::where('url',$data['url'])->first();
    	if($rule)
    	{
    		$this->error_message('当前路由已存在 请重新选择');
    	}

    	$res = PowerRule::create($data);
    	if($res)
    	{
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }
    public function cate(Request $request)
    {
    	if($request->isMethod('get'))
    	{
			return view('Sys.Power.cate',[
			]);
    	}else if($request->isMethod('post'))
    	{	
    		$cate_name = $request->post('cate_name',false)?$request->cate_name:'';
    		$data = PowerCate::where('cate_name','like','%'.$cate_name.'%')
    				->with('Rules')
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();
		   	foreach($data as $k => $v)
		   	{
		   		if(!empty($v['rules']))
		   		{
		   			$data[$k]['url'] = '';
		   			$i = 1;
		   			foreach($v['rules'] as $key => $val)
		   			{	
		   				if($i == 1)
		   				{
		   					$data[$k]['url'] .= $val['rule_name'];
		   				}else
		   				{
		   					$data[$k]['url'] .= '&nbsp;/&nbsp;'.$val['rule_name'];
		   				}
		   				$i++;
		   			}
		   		}else
		   		{
		   			$data[$k]['url'] = '无';
		   		}
		   	}
    		$total = PowerCate::where('cate_name','like','%'.$cate_name.'%')->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }

    public function cate_edit(Request $request)
    {
		$model = PowerCate::find($request->id);
    	if($model)
    	{
    		$model->cate_name = $request->cate_name;
    		$model->save();
    		$this->success_message('修改成功');
    	}else
    	{
    		$this->error_message('数据不存在 请刷新页面');
    	}
    }

    public function cate_del(Request $request)
    {
    	$id = $request->id;
    	if(!is_array($id))
    	{
    		$id = array($id);
    	}
    	PowerCate::destroy($id);
    	foreach($id as $v)
    	{
    		PowerRule::where('cate_id',$v)->delete();
    	}
    	$this->success_message('删除成功');
    }

    public function cate_add(Request $request)
    {
    	if(!$request->post('cate_name',false))
    	{
    		$this->error_message('参数错误');
    	}
        if(PowerCate::where('cate_name',$request->cate_name)->first())
        {
            $this->error_message('分类已存在');
        }
    	PowerCate::create(array('cate_name'=>$request->cate_name));
    	$this->success_message('新增成功');
    }

    public function role(Request $request)
    {
    	if($request->isMethod('get'))
    	{	
    		$cate = PowerCate::with('Rules')->orderBy('created_at','DESC')->get();
    		return view('Sys.Power.role',[
    			'cate' => $cate
    		]);
    	}else if($request->isMethod('post'))
    	{
    		$role_name = $request->post('role_name',false)?$request->role_name:'';
    		$data = PowerRole::where('role_name','like','%'.$role_name.'%')
    				->with(['Rules'=>function($query){
    					return $query->with('Cate')->orderBy('id')->get();
    				}])
    				->orderBy('created_at','DESC')
		    		->offset(($request->page -1) * $request->limit)
		    		->limit($request->limit)
		    		->get()
		    		->toArray();

		   	foreach($data as $k => $v)
		   	{
		   		if(!empty($v['rules']))
		   		{
		   			$data[$k]['url'] = '';
		   			$i = 1;
		   			foreach($v['rules'] as $key => $val)
		   			{	
		   				if($i == 1)
		   				{
		   					$data[$k]['url'] .= $val['cate']['cate_name'].$val['rule_name'];
		   				}else
		   				{
		   					$data[$k]['url'] .= '&nbsp;/&nbsp;'.$val['cate']['cate_name'].$val['rule_name'];
		   				}
		   				$i++;
		   			}
		   		}else
		   		{
		   			$data[$k]['url'] = '无';
		   		}
		   	}
    		$total = PowerRole::where('role_name','like','%'.$role_name.'%')->count();
    		$this->tableData($total,$data,'获取成功',0);
    	}
    }
	public function role_add(Request $request)
	{
		$data = $request->except('_token','ids');
		if(PowerRole::where('role_name',$data['role_name'])->first())
		{
			$this->error_message('角色已存在');
		}
		$res = PowerRole::create($data);

		if($res)
		{
            if($request->ids)
            {
                foreach($request->ids as $key => $value)
                {   

                    $rule_role['rule_id'] = intval($value);
                    $rule_role['role_id'] = $res->id;
                    PowerRoleRule::create($rule_role);                

                }
            }
            $this->success_message('新增成功');
		}else
		{
			$this->error_message('新增失败');
		}
	}
    public function role_del(Request $request)
    {	
    	$id = $request->id;
    	if(!is_array($id))
    	{
    		$id = array($id);
    	}
    	foreach($id as $v)
    	{
    		PowerRole::destroy($v);
    		PowerRoleRule::where('role_id',$v)->delete();
    	}

    	$this->success_message('删除成功');
    }

    public function role_edit(Request $request)
    {
    	$data = $request->except('_token','ids');
    	$role = PowerRole::find($data['id']);
    	if(!$role)
    	{
    		$this->error_message('修改失败');
    	}
    	$role->role_name = $data['role_name'];
    	$role->describe = $data['describe'];
    	$role->save();
    	PowerRoleRule::where('role_id',$role->id)->delete();
    	if($request->ids)
    	{
    		foreach($request->ids as $v)
    		{
    			PowerRoleRule::create(array('role_id'=>$role->id,'rule_id'=>$v));
    		}
    	}
    	$this->success_message('修改成功');
    }
}
