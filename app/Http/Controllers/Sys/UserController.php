<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Sys\Department;
use App\Model\Sys\User;
use App\Model\Sys\PowerRole;
use App\Model\Sys\UserRole;
class UserController extends Controller
{
    public function department(Request $request)
    {
    	$department = Department::with(['Users'=>function($query){
                        return $query->where('status','!=',-1)->get();
    					}])
    					->get();
    	return view('Sys.User.department',[
    		'department' => $department,
            'label' => $this->label($request->label)
    	]);
    }
    public function departments(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('Sys.User.departments',[
            ]);
        }else if($request->isMethod('post'))
        {
            $name = $request->post('name',false)?$request->name:'';
            $data = Department::where('name','like','%'.$name.'%')
                    ->with('Users')
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            foreach($data as $k => $v)
            {  

                if(isset($v['users']))
                {   
                    $data[$k]['user'] = '';
                    $i = 1;
                    foreach($v['users'] as $val)
                    {
                        if($i == 1)
                        {
                            $data[$k]['user'] .= $val['username'];
                        }else
                        {
                            $data[$k]['user'] .= '&nbsp/&nbsp;'.$val['username'];

                        }
                        $i++;
                    }
                }
            }
            $total = Department::where('name','like','%'.$name.'%')->count();
            $this->tableData($total,$data,'获取成功',0);

        }
    }
    public function department_add(Request $request)
    {
    	$data = $request->except('_token');
    	if(Department::where('name',$data['name'])->first())
    	{
    		$this->error_message('该部门已存在');
    	}
    	$res = Department::create($data);
    	if($res)
    	{
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    	
    }
    public function department_edit(Request $request)
    {
        $model = Department::find($request->id);
        if(!$model)
        {
            $this->error_message('数据不存在 请刷新页面');
        }
        $models = Department::where('name',$request->name)->first();
        if($models && $models->id != $model->id)
        {
            $this->error_message('部门名称已存在');
        }
        $model->name = $request->name;
        $model->describe = $request->describe;
        $model->save();
        $this->success_message('修改成功');
    }

    public function department_del(Request $request)
    {
        $id = $request->id;
        if(!is_array($id))
        {
            $model = Department::find($id);
            if($model && $model->status == 2)
            {
                $this->error_message('系统默认部门 禁止删除');
            }

            Department::where('id',$id)->delete();
            $this->success_message('删除成功');
        }
        foreach($id as $k => $v)
        {
            $model = Department::find($v);
            if($model && $model->status == 2)
            {
                unset($id[$k]);
            }
        }
        Department::destroy($id);
        $this->success_message('删除成功');

    }
    public function user_add(Request $request)
    {
    	$data = $request->except('_token','password_s','password');
        $data['password_hash'] = Hash::make($request->password);

    	if(User::where('username',$data['username'])->first())
    	{
    		$this->error_message('用户名已存在');
    	}
    	if(User::where('phone',$data['phone'])->first())
    	{
    		$this->error_message('手机号已存在');
    	}
    	if(User::where('email',$data['email'])->first())
    	{
    		$this->error_message('邮箱已存在');
    	}
    	
    	$res = User::create($data);
    	if($res)
    	{
    		$this->success_message('新增成功');
    	}else
    	{
    		$this->error_message('新增失败');
    	}
    }

    public function user(Request $request)
    {
        if($request->isMethod('get'))
        {   
            $role = PowerRole::get();
            $department = Department::get();
            return view('Sys.User.user',[
                'department' => $department,
                'role' => $role
            ]);
        }else if($request->isMethod('post'))
        {
            $username = $request->post('username',false)?$request->username:'';
            $data = User::where('username','like','%'.$username.'%')
                    ->where('status','!=',-1)
                    ->with('Department')
                    ->with('Roles')
                    ->orderBy('created_at','DESC')
                    ->offset(($request->page -1) * $request->limit)
                    ->limit($request->limit)
                    ->get()
                    ->toArray();
            foreach($data as $k => $v)
            {   
                if(isset($v['department']))
                {
                $data[$k]['department'] = $v['department']['name'];

                }

                if(isset($v['roles']))
                {   
                    $data[$k]['role'] = '';
                    $i = 1;
                    foreach($v['roles'] as $val)
                    {
                        if($i == 1)
                        {
                            $data[$k]['role'] .= $val['role_name'];
                        }else
                        {
                            $data[$k]['role'] .= '&nbsp/&nbsp;'.$val['role_name'];

                        }
                        $i++;
                    }
                }
                if($v['type'] == 10)
                {
                    $data[$k]['role'] = '管理员';
                }
            }
            $total = User::where('username','like','%'.$username.'%')->where('status','!=',-1)->count();
            $this->tableData($total,$data,'获取成功',0);
        }

    }

    public function user_status(Request $request)
    {
        $id = $request->id;

        $user = User::find($id);
        if(!$user)
        {
            $this->error_message('用户不存在');
        }
        if($user->type == 10)
        {
            $this->error_message('管理员用户无法操作');
        }
        $user->status = $request->status;
        $user->save();
        $this->success_message('操作成功');
    }

    public function user_edit(Request $request)
    {
        $id = $request->id;
        $department_id = $request->department_id;
        $ids = $request->post('ids',false);
        $post = $request->post('post');
        $username = $request->post('username');
        $user = User::find($id);
        if(!$user)
        {
            $this->error_message('用户不存在');
        }
        if($user->type == 10)
        {
            $this->error_message('管理员用户无法操作');
        }

        $userUsed = User::where('username',$username)->first();
        if($userUsed && $userUsed->id != $user->id)
        {
            $this->error_message('用户名已存在');
        }

        $user->department_id = $department_id;
        $user->post = $post;
        $user->username = $username;
        $user->save();
        UserRole::where('user_id',$user->id)->delete();

        if($ids)
        {   
            foreach($ids as $v)
            {
                UserRole::create(array('user_id'=>$user->id,'role_id'=>$v));
            }
        }

        $this->success_message('修改成功');
    }

    public function user_del(Request $request)
    {
        $id = $request->id;
        if(!is_array($id))
        {
            $id = array($id);
        }

        foreach($id as $v)
        {
            $model = User::find($v);
            if(!empty($model))
            {
                if($model->type != 10)
                {
                    $model->status = -1;
                    $model->save();
                }
            }
        }
        return $this->success_message('删除成功');
    }

    public function personal(Request $request)
    {   
        $member = User::find(\session('user')['id']);
        return view('Sys.User.personal',[
            'member' => $member
        ]);
    }

    public function personal_edit(Request $request)
    {   
        sleep(1);
        $data = $request->except('_token');
        $user = User::find($data['id']);
        // $username = User::where('username',$data['username'])->first();
        // if($username && $username->id != $user->id)
        // {
        //     $this->error_message('用户名已存在');
        // }
        $phone = User::where('phone',$data['phone'])->first();
        if($phone && $phone->id != $user->id)
        {
            $this->error_message('手机号已存在');
        }
        $email = User::where('email',$data['email'])->first();
        if($email && $phone->id != $user->id)
        {
            $this->error_message('手机号已存在');
        }

        User::where('id',$user->id)->update($data);
        $this->success_message('修改成功');
    }

    public function personal_password(Request $request)
    {           
        if($request->isMethod('get'))
        {
            return view('Sys.User.personal_password');
        }else if($request->isMethod('post'))
        {   
            sleep(1);
            $oldPassword = $request->oldPassword;
            $password = $request->password;
            $id = \session('user')['id'];
            $user = User::find($id);
            if(!Hash::check($oldPassword,$user->password_hash))
            {
                $this->error_message('密码错误');
            }
            $user->password_hash = Hash::make($password);
            $user->save();
            $this->success_message('修改成功');
        }
    }

    public function personal_head_portrait(Request $request)
    {
        $models = User::find($request->id);
        if($models)
        {
            if($request->hasFile('photo'))
            {
                if($request->file('photo')->isValid())
                {
                    $extension = $request->photo->extension();
                    $newName = time().mt_rand(111111,999999).'.'.$extension;
                    $url = $request->photo->storeAs('/images/head',$newName,'user');
                    if($url)
                    {   
                        $image = $models->head_portrait;
                        $path = env('UPLOAD_USER').'/'.$url;
                        $models->head_portrait = $path;
                        $res = $models->save();
                        if($res)
                        {  
                            if($image)
                            {
                                @unlink(substr($image,1));
                            }
                            $this->success_message('上传成功',['src'=>asset($path)]);
                        }else
                        {
                            @unlink(substr($path,1));
                            $this->error_message('上传失败');
                        }
                    }
                }
            }
        }
        $this->error_message('上传失败');
    }
}
