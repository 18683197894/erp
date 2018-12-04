<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
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
        if(!\session()->exists('user'))
        {
            return redirect('/login');
        }

        $user = \session('user');
        $model = \App\Model\Sys\User::find($user['id']);

        if(!$model || $model->status == 0 || $model->status == -1)
        {   
            if($request->ajax())
            {
                die(json_encode(['code'=>501,'msg'=>'此账号已被禁用'])); 
            }
            $request->session()->forget('user');
            return redirect('/login')->with('error','此账号已被禁用');
        }
        if($model->last_time > $user['last_time'])
        {
            if($request->ajax())
            {
                die(json_encode(['code'=>501,'msg'=>'此账号已在别处登录'])); 
            }
           $request->session()->forget('user');
           return redirect('/login')->with('error','此账号已在别处登录');
        }
        
        return $next($request);
    }
}
