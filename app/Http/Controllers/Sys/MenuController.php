<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\Menu;
class MenuController extends Controller
{
    public function menu(Request $request)
    {	
        $app = app();
        $routes = $app->routes->getRoutes();
        $path = [];
        foreach ($routes as $k=>$value)
        {
            if( isset($value->action['middleware']) && in_array('user',$value->action['middleware']))
            {
                $path[$k] = $value->uri;
            }
        }
     
    	$menu = Menu::where('level',1)
    					->with(['Menus'=>function($query){
    						return $query->with(['Menus'=>function($query){
    							return $query->orderBy('sort')->get();
    						}])->orderBy('sort')->get();
    					}])
    					->orderBy('sort')
    					->get();
    	return view('Sys.Nav.menu',[
    		'menu' => $menu,
    		'path' => $path
    	]);
    }

    public function menu_add(Request $request)
    {
    	$data = $request->except('_token');
    	if($data['pid'] != 0)
    	{	
    		$data['level'] = 1;
    		$data['level'] += Menu::find($data['pid'])->level; 
    		if($data['url'] != '#')
    		{
    			$data['url'] = '/'.$data['url'];
    		}
    	}
    	$res = Menu::create($data);
    	if($res)
    	{
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }
    public function menu_edit(Request $request)
    {   
        $data = $request->except('_token');
        $model = Menu::find($data['id']);
        if(!$model)
        {
            $this->error_message('数据不存在');
        }
        if($model->status == 2)
        {
            $this->error_message('系统默认菜单 已禁止编辑'); 
        }
        $model->status = $data['status'];
        $model->title = $data['title'];
        $model->lcon = $data['lcon'];
        $model->url = $data['url'];
        $model->sort = $data['sort'];
        if($model->save())
        {
            $this->success_message('编辑成功');
        }else
        {
            $this->error_message('编辑失败');
        }
    }
    public function menu_del(Request $request)
    {	
    	$menu = Menu::find($request->id);
    	if($menu)
    	{	
            if($menu->status == 2)
            {
                $this->error_message('系统默认菜单 已禁止删除');
            }
    		$del = array($menu->id);

			$models = Menu::select('id','pid')
					->where('id',$menu->id)
					->with(['Menus'=>function($query){
						return $query->select('id','pid')->with(['Menus'=>function($querys){
							return $querys->select('id','pid')->get();
						}])->get();
					}])->get()->toArray();
			foreach($models as $v)
			{
				if(isset($v['menus']) && !empty($v['menus']))
				{
					foreach($v['menus'] as $val)
					{
						array_push($del,$val['id']);
	    				if(isset($val['menus']) && !empty($val['menus']))
	    				{
	    					foreach($val['menus'] as $value)
	    					{
	    						array_push($del,$value['id']);
	    						
	    					}
	    				}
					}
				}
			}
   
    		Menu::destroy($del);
    		$this->success_message('删除成功');
    	}else
    	{
    		$this->error_message('数据不存在 请刷新列表');
    	}
    	// $this->success_message('删除成功');
    }

    public function menu_sort(Request $request)
    {
    	$model = Menu::find($request->id);
    	if($model)
    	{
    		$model->sort = intval($request->sort);
    		$model->save();
    		$this->success_message('');
    	}else
    	{
    		$this->error_message('数据不存在 请刷新页面');
    	}
    }
}
