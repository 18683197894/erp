@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card department_add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform" lay-filter="component-form-group">
          <div class="layui-form-item">
            <label class="layui-form-label">部门名称</label>
            <div class="layui-input-block">
              <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="请输入部门名称" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">部门表述</label>
            <div class="layui-input-block">
              <textarea name="describe" placeholder="请输入部门描述" class="layui-textarea"></textarea>
            </div>
          </div>
       
          <div class="layui-form-item">
            <div class="layui-input-block">
              <div class="layui-footer" style="left: 0;">
                <button class="layui-btn" lay-submit="" lay-filter="department_add">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
              </div>
            </div>
          </div>
        </form>
      </div>
</div>
<div class="layui-card department_edit" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" lay-filter="component-form-group">
          <input type="hidden" name="id" value="">
          <div class="layui-form-item">
            <label class="layui-form-label">部门名称</label>
            <div class="layui-input-block">
              <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="请输入部门名称" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">部门表述</label>
            <div class="layui-input-block">
              <textarea name="describe" placeholder="请输入部门描述" class="layui-textarea"></textarea>
            </div>
          </div>
       
          <div class="layui-form-item">
            <div class="layui-input-block">
              <div class="layui-footer" style="left: 0;">
                <button class="layui-btn" lay-submit="" lay-filter="department_edit">立即提交</button>
              </div>
            </div>
          </div>
        </form>
      </div>
</div>
@endsection
@section('content')

<div class="layui-card-body">
	<div class="demoTable" style="padding-bottom: 10px">
		<div class="layui-input-inline">
		  <input class="layui-input" name="name" id="name" placeholder="部门名称搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增部门','.department_add',0.5,0.6)">新增部门</button>
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
  
    var tab = table.render({
      elem: '#test-table-toolbar'
      ,url: '/user/departments'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '用户数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left',width:80}
        ,{field:'id', title:'ID', fixed: 'left', unresize: true,width:80}
        ,{field:'name', title:'部门名称',width:150}
        ,{field:'describe', title:'部门描述'}
        ,{field:'user', title:'成员'}
        ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
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
    	name = $('#name').val();
    	tab.reload({where:{name:name,_token:token},page:{curr:1}});
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
        layer.confirm('确定删除权限ID: '+id+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/user/department-del") }}',
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
        layer.confirm('确定删除部门: '+data.name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/user/department-del") }}',
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
          var width = ($(window).width() * 0.5)+'px';
          var height = ($(window).height() * 0.6)+'px';
          $('.department_edit').find("input[name='id']").val(data.id);
          $('.department_edit').find("input[name='name']").val(data.name);
          $('.department_edit').find("textarea[name='describe']").val(data.describe);
          department_edit = layer.open({
            type : 1,
            title : '部门编辑',
            fix: false, //不固定
                maxmin: true,
                shadeClose: true,
                shade: 0.4,
            area : [width,height],
            content : $('.department_edit')
          })
      }
    });
    form.on('submit(department_add)',function(data){
      data = data.field;
      data._token = token
 
      $.ajax({
        url : '{{url("/user/department-add")}}',
        type : 'post',
        data : data,
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          { 
            layer.close(opens);
            layMsgOk(res.msg);
            $('#name').val('');
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
    form.on('submit(department_edit)',function(data){
      data = data.field;
      data._token = token
      console.log(data);
      $.ajax({
        url : '{{url("/user/department-edit")}}',
        type : 'post',
        data : data,
        success : function(res)
        {
          res = $.parseJSON(res);
          if(res.code == 200)
          { 
            layer.close(department_edit);
            layMsgOk(res.msg);
            tab.reload()
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
  });
  </script>
@endsection