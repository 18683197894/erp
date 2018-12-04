<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Sys\User;
class LoginController extends Controller
{
    public function dologin(Request $request)
    {
	 	$this->validate($request, [
	        'captcha' => 'required|captcha'
	    ],[
	        'captcha.required' => '请填写验证码',
	        'captcha.captcha' => '验证码错误',
	    ]);

	 	$username = $request->post('username');
    	$password = $request->post('password');
    	$models = User::where('username',$username)->first();

    	if($models)
    	{	
    		if($models->status == 0)
    		{	
    			$this->error_message('用户被禁用');
    		}
            if($models->status == -1)
            {   
                $this->error_message('用户不存在');
            }

    		if(Hash::check($password,$models->password_hash))
    		{	
    			
    			$models->visit_count += 1;
    			$models->last_time = time();
    			$models->last_ip = $request->getClientIp();
    			$models->save();
    			$backend = $models->toArray();
    			unset($backend['password_reset_key']);
    			unset($backend['password_hash']);
                
    			\session(['user'=>$backend]);
    			\session()->save();
    			$this->success_message('登录成功');
    		}else
    		{	
    			$this->error_message('密码错误');
    		}
    	}else
    	{	

    		$this->error_message('户名不存在');
    	}
	}
}
