@extends('public')

@section('content')
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" id="oldPassword" lay-verify="required" lay-verType="tips" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit="" lay-filter="setmypass">确认修改</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection()

@section('js')
  <script>
layui.config({
	base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
	}).extend({
	index: 'lib/index' //主入口模块
	}).use(['index','form'],function(){
	$ = layui.jquery
	,form = layui.form;
	token = $("meta[name='csrf-token']").attr('content');
	form.verify({
		// pass: [/^[\S]{6,12}$/,'密码必须6到12位，且不能出现空格'],
		pass : function(value)
		{	
			var reg = /^[\S]{6,12}$/;
			if(!reg.test(value))
			{
				return '密码必须6到12位，且不能出现空格'
			}
			if(value == $('#oldPassword').val())
			{
				return '新密码与原密码相同';
			}
		},
		repass: function(value){
			if(value !== $('#LAY_password').val()){
			return '两次密码输入不一致';
		}
		}
	});
	form.on('submit(setmypass)',function(data){
		var load = layer.load(2, {
		  shade: [0.2,'#f0f0f0'] //0.1透明度的白色背景
		});
		data.field._token = token;
		$.ajax({
			url : "{{ url('/user/personal-password') }}",
			type : 'post',
			data : data.field,
			success : function(res)
			{	
				layer.close(load);
				res = $.parseJSON(res);
				if(res.code == 200)
				{
					layer.alert(res.msg,{title:'密码修改',icon:6,closeBtn:1,btn:['确定'],yes:function(){
						parent.indexHerf('{{ url("/login") }}');
					},cancel:function(){
						parent.indexHerf('{{ url("/login") }}');
					}});
				}else
				{
					layer.alert(res.msg,{title:'密码修改',icon:5,closeBtn:1,btn:['关闭']});
				}

			},
			error : function(error)
			{
				layer.close(load);
				layer.alert('修改失败 请联系管理员',{title:'密码修改',icon:5,closeBtn:1,btn:['关闭']});
			}
		})
		return false;
	})
  });
  </script>
@endsection