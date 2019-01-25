<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sys\User;
use App\Model\Sys\Menu;
class IndexController extends Controller
{
    public function index(Request $request)
    {   
        $menu = Menu::where('level',1)
                ->where('status','!=',0)
                ->with(['Menus'=>function($query){
                    return $query->where('status','!=',0)->with(['Menus'=>function($query){
                        return $query->where('status','!=',0)->orderBy('sort')->get();
                    }])->orderBy('sort')->get();
                }])
                ->orderBy('sort')
                ->get()->toArray();
        
    	$models = User::find(\session('user')['id']);
        $id = \session('user')['id'];
        if($models['type'] != 10)
        {
            $role = $models['roles'];
            $rules = array();
            foreach($role as $k => $v)
            {   
                foreach($v['rules'] as $kk => $vv)
                {   
                    if(!in_array($vv->url, $rules))
                    {
                        array_push($rules,$vv->url);
                    }
                }
            }

            foreach($menu as $m => $e)
            {   
                if($e['status'] == 2)
                {
                    $level1 = true;
                }else
                {
                    $level1 = false;
                }

                foreach($e['menus'] as $mm => $ee)
                {       

                    if($ee['url'] == '#')
                    {
                        if($ee['status'] == 2)
                        {   
                            $level1 = true;
                            $level2 = true;
                        }else
                        {
                            $level2 = false;
                        }
                        foreach($ee['menus'] as $mmm => $eee)
                        {
                            if($eee['status'] == 2)
                            {
                                $level1 = true;
                                $level2 = true;
                            }else
                            {
                                if(in_array($eee['url'], $rules))
                                {
                                    $level1 = true;
                                    $level2 = true;
                                }else
                                {
                                    unset($menu[$m]['menus'][$mm]['menus'][$mmm]);
                                }
                            }
                        }

                        if($level2 == false)
                        {
                            unset($menu[$m]['menus'][$mm]);
                        }else
                        {
                            $level1 = true;
                        }
                    }else
                    {
                        if(in_array($ee['url'],$rules))
                        {   
                            $level1 = true;
                        }else
                        {   
                            if($ee['status'] != 2)
                            {
                                unset($menu[$m]['menus'][$mm]);
                            }else
                            {
                                $level1 = true;
                            }
                        }
                    }
                }

                if($level1 == false)
                {
                    unset($menu[$m]);
                }
            }
        }
        return view('Sys.Index.index',[
    		'user' => $models,
            'menu' => $menu
    	]);
    }

    public function welcome_one(Request $request)
    {   
    	return view('Sys.Index.welcome_one',[

    	]);
    }
}
