<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Sys\User;

class RuleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        $id = \session('user')['id'];
        $models = User::find($id);
        if($models->type == 10)
        {
            return $next($request);
        }
        $role = $models->roles;
        if(!$role)
        {
            if($request->ajax())
            {
                die(json_encode(['code'=>501,'msg'=>'无权限'])); 
            }
            return response()->view('Error.403');
        }
        $rules = array();
        foreach($role as $k => $v)
        {   
            foreach($v->rules as $kk => $vv)
            {   
                $rules[$kk] = $vv->url;
            }
        }
        if(!in_array('/'.$path,$rules))
        {   
            if($request->ajax())
            {
                die(json_encode(['code'=>501,'msg'=>'无权限'])); 
            }
            return response()->view('Error.403');
        }

        return $next($request);
    
    }
}
