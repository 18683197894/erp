@extends('public')

@section('css')

@endsection

@section('open')
<div class="layui-card rule_add" style="display:none">
      <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" id="myform"lay-filter="component-form-group">
          <div class="layui-form-item">
            <label class="layui-form-label">权限分类</label>
            <div class="layui-input-block">
              <select name="cate_id" lay-filter="required" lay-search="" lay-verify="required">
                <option value="">直接选择或搜索选择</option>
                @foreach($cate as $c)
                <option value="{{ $c->id }}">{{ $c->cate_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">路由规则</label>
              <div class="layui-input-block">
                <select name="url" lay-verify="required" lay-search="">
                  <option value="">直接选择或搜索选择</option>
                  @foreach($path as $p)
                  <option value="{{ $p }}">{{ $p }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="layui-form-item" >
            <label class="layui-form-label">权限名</label>
            <div class="layui-input-block">
              <input name="rule_name" value="" lay-verify="required" placeholder="请输入权限名" autocomplete="off" class="layui-input" type="text">
            </div>
          </div>
          <div class="layui-form-item ">
            <div class="layui-input-block">
            <br>
              <div class="layui-footer">
                <button class="layui-btn" lay-submit="" lay-filter="rule_add">立即提交</button>
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
		  <input class="layui-input" name="rule_name" id="rule_name" placeholder="权限名搜索" autocomplete="off">
		</div>
		<button class="layui-btn">搜索</button>
	</div>
	<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

	<script type="text/html" id="test-table-toolbar-toolbarDemo">
	  <div class="layui-btn-container">
	    <button class="layui-btn layui-btn-sm  layui-btn-danger" lay-event="getCheckData">批量删除</button>
	    <button class="layui-btn layui-btn-sm" onclick="open_show('新增权限','.rule_add',0.5,0.6)">新增权限</button>
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
      ,url: '/power/rule'
      ,where:{_token:token}
      ,method:'post'
      ,toolbar: '#test-table-toolbar-toolbarDemo'
      ,title: '用户数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left',width:80}
        ,{field:'id', title:'ID', fixed: 'left', unresize: true,width:80}
        ,{field:'rule_name', title:'权限名',width:150}
        ,{field:'url', title:'路由',width:280}
        ,{field:'cate_name', title:'分类'}
        ,{field:'created_at', title:'创建时间'}
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
    	rule_name = $('#rule_name').val();
    	tab.reload({where:{rule_name:rule_name,_token:token},page:{curr:1}});
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
          	url:'{{ url("/power/rule-del") }}',
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
        layer.confirm('确定删除权限: '+data.rule_name+' 吗', function(index){
        	$.ajax({
          	url:'{{ url("/power/rule-del") }}',
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
        layer.prompt({
        	title : '修改权限名'
          ,formType: 2
          ,value: data.rule_name
        }, function(value, index){
          $.ajax({
          	url:'{{ url("/power/rule-edit") }}',
          	type : 'post',
          	data : {id:data.id,rule_name:value,_token:token},
          	success : function(res)
          	{	
          		res = $.parseJSON(res);
          		if(res.code == 200)
          		{
					obj.update({
						rule_name: value
					});
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
      }
    });
    form.on('submit(rule_add)',function(data){
      data = data.field;
      data._token = token;
      $.ajax({
        url : '{{ url("/power/rule-add") }}',
        type : 'post',
        data : data,
        success : function(res)
        { 
          res = $.parseJSON(res);
          if(res.code == 200)
          {
            layer.close(opens);
            layMsgOk(res.msg);
            $('#rule_name').val('');
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
          layMsgError('新增失败');
        }
      })
      return false;
    })
  });
  </script>
@endsection