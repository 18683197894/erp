@extends('public')

@section('css')
<style type="text/css">
</style>
@endsection

@section('open')
<div class="layui-card user_add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
         <form class="layui-form" id="myform"  lay-filter="component-form-group" autocomplete="off">
          <input type="hidden" name="department_id" index="pid" value="">
          <div class="layui-form-item" >
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
              <input name="username" value="" lay-verify="required|username" placeholder="请输入真实姓名" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
              <input name="sex" value="1" title="男" checked="ckecked"  type="radio"><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><div>男</div></div>
              <input name="sex" value="2" title="女"   type="radio"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>女</div></div>
            </div>
          </div>   
          <div class="layui-form-item" >
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-block">
              <input name="phone" value="" lay-verify="required|phone" placeholder="请输入手机号" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
              <input name="email" value="" lay-verify="required|email" placeholder="请输入邮箱" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>        
          <div class="layui-form-item">
            <label class="layui-form-label">所属部门</label>
              <div class="layui-input-block">
                <select name="department_id" lay-verify="required" lay-search="">
                  <option value="">直接选择或搜索选择</option>
                  @foreach($department as $p)
                  <option value="{{ $p->id }}">{{ $p->name }}</option>
                  @endforeach
                </select>
              </div>
          </div> 
          <div class="layui-form-item" >
            <label class="layui-form-label">职务</label>
            <div class="layui-input-block">
              <input  name="post" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>  
          <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
              <input name="password" lay-verify="passwords" placeholder="请输入密码" autocomplete="off" class="layui-input" type="password">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">重复密码</label>
            <div class="layui-input-block">
              <input name="password_s" lay-verify="passwords_s" placeholder="请输入密码" autocomplete="off" class="layui-input" type="password">
            </div>
          </div>
          <hr>
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="" lay-filter="user_add">立即提交</button>
              </div>
            </div>
          </div> 
        </form>
      </div>
</div>
<div class="layui-card user_edit" style="display:none;position:relative;z-index:20">
  <div class="layui-card-body" style="padding: 15px;">
    <form class="layui-form layui-form-pane">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="ids" value="">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                    <input type="text" id="name" name="username" required="" lay-verify="required|username" placeholder="请输入"
                    autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" >
              <label class="layui-form-label">职务</label>
              <div class="layui-input-block">
                <input  name="post" value="" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">部门</label>
              <div class="layui-input-block">
                <select name="department_id" lay-filter="required" lay-verify="required">
                  <option value=""></option>
                  @foreach($department as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>
            </div> 
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    拥有权限
                </label>
                <table id="inputs" class="layui-table layui-input-block">
                    <tbody>
                        <tr>
                            <td>
                                <div class="layui-input-block">
                                @foreach($role as $value)
                                <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $value->id }}'>
                                <i class="layui-icon">&#xe605;</i><span>{{ $value->role_name }}</span>
                                </div>
                                    
                                @endforeach
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="user_edit">修改</button>
          </div>
        </form>
    </div>
</div>
@endsection
@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
		  <input class="layui-input" name="username" id="username" placeholder="用户名搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增用户','.user_add',0.7,0.8)">新增用户</button>
	  </div>
	</script>

	<script type="text/html" id="test-table-toolbar-barDemo">
	  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
</div>
  
@endsection

@section('js')
<script>
  layui.config({
    base: '{{ asset("/layui/layuiadmin/") }}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table'], function(){
    admin = layui.admin
    ,$ = layui.jquery
    ,form = layui.form
    ,table = layui.table;
    token = $("meta[name='csrf-token']").attr('content');
    tableCheck.init();
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/user/user'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '用户数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', title:'ID', fixed: 'left',width:60}
        ,{field:'username', title:'用户名'}
        ,{field:'department', title:'部门'}
        ,{field:'post', title:'职务'}
        ,{field:'phone', title:'电话'}
        ,{field:'email', title:'邮箱',width:190}
        ,{field:'role', title:'用户角色',width:200}
        ,{field:'status', title:'状态',width:100,templet:function(d){
          if(d.status == 0)
          {
    
            return "<button class='layui-btn layui-btn-xs layui-btn-primary'>已禁用</button>";
          }else
          {
            return "<button class='layui-btn layui-btn-xs layui-btn-normal'>已启用</button>";
          }
        },event:'userStatus'}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo'}

      ]]
      ,page: true
    ,parseData: function(res){ //res 即为原始返回的数据
	    return {
	      "code": res.code, //解析接口状态
	      "msg": res.msg, //解析提示文本
	      "count": res.total, //解析数据长度
	      "data": res.data //解析数据列表
	    };
	  }
    });
    $('.demoTable .layui-btn').on('click',function(){
    	username = $('#username').val();
    	tab.reload({where:{username:username,_token:token},page:{curr:1}});
    });
    //头工具栏事件
    table.on('toolbar(test-table-toolbar)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;
          if(data.length <= 0) return false;
          var id = new Array();
          $.each(data,function(i,n){
          	id.push(n.id);
          });
        layer.confirm('确定删除用户ID: '+id+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/user/user-del") }}',
          	type : 'post',
          	data : {id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{

					layer.close(index);
					layMsgOk(res.msg);
					// location.reload(true);
					tab.reload();
          		}else
          		{
          			layMsgError(res.msg);
          		}
          	},
          	error : function(error)
          	{
          		layMsgError('操作失败');
          	}
          })
        });
          // layer.alert(JSON.stringify(data));
        break;
        case 'getCheckLength':
          // var data = checkStatus.data;
          // layer.msg('选中了：'+ data.length + ' 个');
        break;
        case 'isAll':
          // layer.msg(checkStatus.isAll ? '全选': '未全选');
        break;
      };
    });
    
    //监听行工具事件
    table.on('tool(test-table-toolbar)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('确定删除用户: '+data.username+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/user/user-del") }}',
          	type : 'post',
          	data : {id:data.id,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{
          			obj.del();
					      layer.close(index);
					      layMsgOk(res.msg);
          		}else
          		{
          			layMsgError(res.msg);
          		}
          	},
          	error : function(error)
          	{
          		layMsgError('操作失败');
          	}
          })
        });
      } else if(obj.event === 'edit'){
          var width = ($(window).width() * 0.6)+'px';
          var height = ($(window).height() * 0.7)+'px';
          $('.user_edit').find("input[name='username']").val(data.username);
          $('.user_edit').find("input[name='post']").val(data.post);
          $('.user_edit').find("input[name='id']").val(data.id);
          $('.user_edit').find("dd[lay-value='"+data.department_id+"']").click();
          $(".user_edit").find(".layui-form-checkbox").removeClass('layui-form-checked');
          $.each(data.roles,function(index,el){
             $(".user_edit").find("div[data-id='"+el.id+"']").addClass('layui-form-checked');
          });
          user_edit = layer.open({
            type : 1,
            title : '用户编辑',
            fix: false, //不固定
                maxmin: true,
                shadeClose: true,
                shade: 0.4,
            area : [width,height],
            content : $('.user_edit')
          })
      }else if(obj.event == 'userStatus'){ 
        if(data.status == 1)
        {

          var itps = '禁用'
          var status = 0;
        }else
        {
          var itps = '启用'
          var status = 1;
        }
        layer.confirm('确定要'+itps+'用户: '+data.username+' 吗',function(index){
            $.ajax({
              url :'{{ url("/user/user-status") }}',
              type : 'post',
              data : {id:data.id,status:status,_token:token},
              success : function(res)
              {
                res = $.parseJSON(res);
                if(res.code == 200)
                {
                  obj.update({
                    status : status
                  });
                  layMsgOk(res.msg);
                }else
                {
                  layMsgError(res.msg);
                }
              },
              error : function(error)
              {
                layMsgError('操作失败');
              }
            })
            layer.close(index);
        });
      }
    });
    form.on('submit(user_add)',function(data){
      data = data.field;
      data._token = token
 
      $.ajax({
        url : '{{url("/user/user-add")}}',
        type : 'post',
        data : data,
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          { 
            layer.close(opens);
            layMsgOk(res.msg);
            $('#username').val('');
            tab.reload({
              where : {_token:token},
              page : {cuur:1}
            })
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('操作失败 请联系管理员');
        }
      })
      return false;
    })
    form.on('submit(user_edit)',function(data){
      data = data.field;
      data._token = token;
      data.ids = tableCheck.getDate($('.user_edit'));
      data._token = token;

      $.ajax({
        url : '{{ url("/user/user-edit") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(user_edit);
            layMsgOk(res.msg);
            tableCheck.tableCheckClose($('.user_edit'));
            tab.reload()
          }else
          {
            layMsgError(res.msg);
          }
        },
        error : function(error)
        {
          layMsgError('修改失败');
        }
      })
      return false;
    })
    form.verify({
      username:function(value)
      {
        if(value != '' && !value.match(/^[\u4E00-\u9FA5]{2,4}$/))
        {
          return '姓名格式错误';
        }
      },
      passwords: function(value)
      {
          if(value == false)
          {
            return '密码不能为空';
          }
          if(!value.match(/[A-Za-z0-9_\-.]{6,16}$/))
          {
            return '密码格式错误';
          }
      },
      passwords_s: function(value)
      {

          if(value != $('.user_add').find("input[name='password']").val())
          {
            return '密码不一致';
          }
      }
    });
  });
  </script>
@endsection